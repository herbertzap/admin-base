<?php

namespace App\Services\Hermes;

use App\Models\HermesLog;
use App\Models\Tatc;
use App\Models\Tstc;
use App\Models\Salida;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HermesService
{
    private $baseUrl;
    private $apiKey;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = config('hermes.base_url', 'https://api-hermes.aduana.cl');
        $this->apiKey = config('hermes.api_key', 'WW2Psa5F201ONZHSxuDif8M7smW12pE29tvups3l');
        $this->timeout = config('hermes.timeout', 30);
    }

    /**
     * Enviar TATC a HERMES (Tipo 01 - Liberación)
     */
    public function enviarTatc(Tatc $tatc)
    {
        $payload = $this->construirPayloadTatc($tatc);
        
        return $this->enviarMensaje(
            'TATC',
            $tatc->numero_tatc,
            $payload,
            '/mensajeria/tatc'
        );
    }

    /**
     * Enviar evento de modificación TATC a HERMES (Tipo 02 - MOD)
     */
    public function enviarModificacionTatc(Tatc $tatc)
    {
        $payload = $this->construirPayloadModificacionTatc($tatc);
        
        return $this->enviarMensaje(
            'TATC_MOD',
            $tatc->numero_tatc,
            $payload,
            '/mensajeria/tatc'
        );
    }

    /**
     * Enviar evento de cancelación TATC a HERMES (Tipo 02 - CAN)
     */
    public function enviarCancelacionTatc(Tatc $tatc)
    {
        $payload = $this->construirPayloadCancelacionTatc($tatc);
        
        return $this->enviarMensaje(
            'TATC_CAN',
            $tatc->numero_tatc,
            $payload,
            '/mensajeria/tatc'
        );
    }

    /**
     * Enviar evento de traspaso TATC a HERMES (Tipo 02 - TRA)
     */
    public function enviarTraspasoTatc(Tatc $tatc)
    {
        $payload = $this->construirPayloadTraspasoTatc($tatc);
        
        return $this->enviarMensaje(
            'TATC_TRA',
            $tatc->numero_tatc,
            $payload,
            '/mensajeria/tatc'
        );
    }

    /**
     * Enviar evento de cumplido TATC a HERMES (Tipo 02 - CUM)
     */
    public function enviarCumplidoTatc(Tatc $tatc)
    {
        $payload = $this->construirPayloadCumplidoTatc($tatc);
        
        return $this->enviarMensaje(
            'TATC_CUM',
            $tatc->numero_tatc,
            $payload,
            '/mensajeria/tatc'
        );
    }

    /**
     * Enviar TSTC a HERMES
     */
    public function enviarTstc(Tstc $tstc)
    {
        $payload = $this->construirPayloadTstc($tstc);
        
        return $this->enviarMensaje(
            'TSTC',
            $tstc->numero_tstc,
            $payload,
            '/mensajeria/tstc'
        );
    }

    /**
     * Enviar Salida a HERMES
     */
    public function enviarSalida(Salida $salida)
    {
        $payload = $this->construirPayloadSalida($salida);
        
        return $this->enviarMensaje(
            'SALIDA',
            $salida->numero_salida,
            $payload,
            '/mensajeria/salida'
        );
    }

    /**
     * Enviar mensaje genérico a HERMES
     */
    private function enviarMensaje($tipoOperacion, $numeroDocumento, $payload, $endpoint)
    {
        $url = $this->baseUrl . $endpoint;
        
        // Crear log de la operación
        $log = HermesLog::create([
            'tipo_operacion' => $tipoOperacion,
            'numero_documento' => $numeroDocumento,
            'payload_enviado' => $payload,
            'estado' => 'ENVIADO',
            'endpoint' => $endpoint,
            'api_key_utilizada' => $this->apiKey,
            'ultimo_intento' => now(),
        ]);

        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])
                ->post($url, $payload);

            $log->update([
                'respuesta_recibida' => $response->json(),
                'codigo_respuesta' => $response->status(),
                'estado' => $response->successful() ? 'EXITOSO' : 'ERROR',
                'mensaje_error' => $response->successful() ? null : $response->body(),
            ]);

            if ($response->successful()) {
                Log::info("HERMES: Mensaje enviado exitosamente", [
                    'tipo' => $tipoOperacion,
                    'documento' => $numeroDocumento,
                    'endpoint' => $endpoint
                ]);
                
                return [
                    'success' => true,
                    'response' => $response->json(),
                    'log_id' => $log->id
                ];
            } else {
                Log::error("HERMES: Error al enviar mensaje", [
                    'tipo' => $tipoOperacion,
                    'documento' => $numeroDocumento,
                    'endpoint' => $endpoint,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return [
                    'success' => false,
                    'error' => $response->body(),
                    'status' => $response->status(),
                    'log_id' => $log->id
                ];
            }

        } catch (\Exception $e) {
            $log->update([
                'estado' => 'ERROR',
                'mensaje_error' => $e->getMessage(),
                'ultimo_intento' => now(),
            ]);

            Log::error("HERMES: Excepción al enviar mensaje", [
                'tipo' => $tipoOperacion,
                'documento' => $numeroDocumento,
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
                'log_id' => $log->id
            ];
        }
    }

    /**
     * Construir payload para TATC (Tipo 01 - Liberación)
     */
    private function construirPayloadTatc(Tatc $tatc)
    {
        return [
            'tipoMensaje' => '01',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTATC' => $tatc->numero_tatc,
            'fechaLiberacionTATC' => $tatc->created_at->format('Y-m-d\TH:i:s'),
            'operadorContenedor' => [
                'codigo' => $tatc->user->operador->codigo ?? 'S46',
                'razonSocial' => $tatc->user->operador->nombre_operador ?? 'Contenedores Tomás Dagnino Vicencio E.I.R.L'
            ],
            'aduana' => [
                'codigo' => $tatc->aduana->codigo ?? 98,
                'nombre' => $tatc->aduana->nombre_aduana ?? 'DNA'
            ],
            'contenedor' => [
                'nroContenedor' => $tatc->numero_contenedor,
                'isocode' => [
                    'codigo' => $tatc->tipo_contenedor,
                    'glosa' => $this->obtenerGlosaContenedor($tatc->tipo_contenedor)
                ],
                'armadorNumeroReserva' => $tatc->tatc_origen ?? '',
                'status' => 'FCL'
            ],
            'datosTransporte' => [
                'viaTransporteMFTO' => $this->mapearViaTransporte($tatc->tipo_ingreso),
                'manifiestoAduana' => $tatc->documento_ingreso ?? '',
                'sentidoOperacion' => 'Ingreso',
                'nroDocTransporte' => $tatc->documento_ingreso ?? '',
                'ciaTransportadora' => [
                    'rut' => $tatc->empresaTransportista->rut ?? '11111111-k',
                    'razonSocial' => $tatc->empresaTransportista->nombre_empresa ?? 'Empresa Transportista'
                ],
                'nave' => [
                    'numeroLloyd' => '',
                    'viaje' => '',
                    'nombre' => 'N/A'
                ],
                'rutChofer' => $tatc->rut_chofer ?? '11111111-k',
                'patenteCamion' => $tatc->patente_camion ?? ''
            ],
            'deposito' => [
                'codigoDeposito' => 'DEP001',
                'razonSocial' => 'Depósito Principal',
                'codigoDepositoDevolucion' => 'DEPDEV001',
                'codigoComunaDeposito' => 'CODCL'
            ],
            'despachador' => [
                'rut' => '11111111-k',
                'razonSocial' => 'Despachador Ejemplo S.A.'
            ],
            'cliente' => [
                'rut' => '11111111-k',
                'razonSocial' => 'Cliente de Ejemplo Ltda.'
            ],
            'observacion' => $tatc->comentario ?? '',
            'puertoDescarga' => $tatc->puerto_ingreso ?? 'Puerto Principal'
        ];
    }

    /**
     * Construir payload para modificación TATC (Tipo 02 - MOD)
     */
    private function construirPayloadModificacionTatc(Tatc $tatc)
    {
        return [
            'tipoMensaje' => '02',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTATC' => $tatc->numero_tatc,
            'fechaEvento' => $tatc->updated_at->format('Y-m-d\TH:i:s'),
            'codTipoEvento' => 'MOD',
            'operadorContenedor' => [
                'codigo' => $tatc->user->operador->codigo ?? 'S46',
                'razonSocial' => $tatc->user->operador->nombre_operador ?? 'Contenedores Tomás Dagnino Vicencio E.I.R.L'
            ],
            'recepcionModificacionTATC' => [
                'fechaModificación' => $tatc->updated_at->format('Y-m-d\TH:i:s')
            ]
        ];
    }

    /**
     * Construir payload para cancelación TATC (Tipo 02 - CAN)
     */
    private function construirPayloadCancelacionTatc(Tatc $tatc)
    {
        return [
            'tipoMensaje' => '02',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTATC' => $tatc->numero_tatc,
            'fechaEvento' => now()->format('Y-m-d\TH:i:s'),
            'codTipoEvento' => 'CAN',
            'operadorContenedor' => [
                'codigo' => $tatc->user->operador->codigo ?? 'S46',
                'razonSocial' => $tatc->user->operador->nombre_operador ?? 'Contenedores Tomás Dagnino Vicencio E.I.R.L'
            ],
            'cancelacionTATC' => [
                'fechaCancelacion' => now()->format('Y-m-d\TH:i:s')
            ]
        ];
    }

    /**
     * Construir payload para traspaso TATC (Tipo 02 - TRA)
     */
    private function construirPayloadTraspasoTatc(Tatc $tatc)
    {
        return [
            'tipoMensaje' => '02',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTATC' => $tatc->numero_tatc,
            'fechaEvento' => now()->format('Y-m-d\TH:i:s'),
            'codTipoEvento' => 'TRA',
            'operadorContenedor' => [
                'codigo' => $tatc->user->operador->codigo ?? 'S46',
                'razonSocial' => $tatc->user->operador->nombre_operador ?? 'Contenedores Tomás Dagnino Vicencio E.I.R.L'
            ],
            'traspasoTATC' => [
                'fechaTraspaso' => now()->format('Y-m-d\TH:i:s')
            ]
        ];
    }

    /**
     * Construir payload para cumplido TATC (Tipo 02 - CUM)
     */
    private function construirPayloadCumplidoTatc(Tatc $tatc)
    {
        return [
            'tipoMensaje' => '02',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTATC' => $tatc->numero_tatc,
            'fechaEvento' => now()->format('Y-m-d\TH:i:s'),
            'codTipoEvento' => 'CUM',
            'operadorContenedor' => [
                'codigo' => $tatc->user->operador->codigo ?? 'S46',
                'razonSocial' => $tatc->user->operador->nombre_operador ?? 'Contenedores Tomás Dagnino Vicencio E.I.R.L'
            ],
            'recepcionCumplidoLiberadoTATC' => [
                'fechaCumplido' => now()->format('Y-m-d\TH:i:s')
            ]
        ];
    }

    /**
     * Construir payload para TSTC
     */
    private function construirPayloadTstc(Tstc $tstc)
    {
        // Similar al TATC pero con campos específicos del TSTC
        return [
            'tipoMensaje' => '01',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTSTC' => $tstc->numero_tstc,
            'fechaLiberacionTSTC' => $tstc->created_at->format('Y-m-d\TH:i:s'),
            // ... otros campos específicos del TSTC
        ];
    }

    /**
     * Construir payload para Salida
     */
    private function construirPayloadSalida(Salida $salida)
    {
        // Payload específico para salidas según el tipo
        return [
            'tipoMensaje' => '02',
            'fechaMensaje' => now()->format('Y-m-d\TH:i:s'),
            'numeroTATC' => $salida->tatc->numero_tatc,
            'fechaEvento' => $salida->created_at->format('Y-m-d\TH:i:s'),
            'codTipoEvento' => $this->mapearTipoSalida($salida->tipo_salida),
            // ... otros campos específicos de la salida
        ];
    }

    /**
     * Obtener glosa del contenedor
     */
    private function obtenerGlosaContenedor($codigo)
    {
        $glosas = [
            '42T9' => 'Tank container for gases - Minimum pressure',
            '4510' => 'Propósito general',
            '42T1' => 'Tank container for gases',
            '42T3' => 'Tank container for gases',
            '42T5' => 'Tank container for gases',
            '42T7' => 'Tank container for gases',
        ];

        return $glosas[$codigo] ?? 'Contenedor estándar';
    }

    /**
     * Mapear vía de transporte
     */
    private function mapearViaTransporte($tipoIngreso)
    {
        $mapeo = [
            'traspaso' => 1,
            'desembarque' => 7,
            'reingreso' => 1
        ];

        return $mapeo[$tipoIngreso] ?? 1;
    }

    /**
     * Mapear tipo de salida
     */
    private function mapearTipoSalida($tipoSalida)
    {
        $mapeo = [
            'Internación' => 'CUM',
            'Cancelación' => 'CAN',
            'Traspaso' => 'TRA'
        ];

        return $mapeo[$tipoSalida] ?? 'CUM';
    }

    /**
     * Reintentar mensajes fallidos
     */
    public function reintentarMensajesFallidos($maxIntentos = 3)
    {
        $logsFallidos = HermesLog::where('estado', 'ERROR')
            ->where('intentos', '<', $maxIntentos)
            ->get();

        foreach ($logsFallidos as $log) {
            $this->reintentarMensaje($log);
        }
    }

    /**
     * Reintentar un mensaje específico
     */
    private function reintentarMensaje(HermesLog $log)
    {
        $log->increment('intentos');
        $log->update(['ultimo_intento' => now()]);

        // Aquí se implementaría la lógica para reenviar el mensaje
        // basándose en el tipo de operación y el payload original
    }
}
