<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HermesApiService
{
    protected $baseUrl;
    protected $token;
    protected $timeout;

    public function __construct()
    {
        $this->baseUrl = config('hermes.api_url', 'https://api.hermes.aduana.cl');
        $this->token = config('hermes.api_token');
        $this->timeout = config('hermes.timeout', 30);
    }

    /**
     * Enviar TATC a la API de Hermes
     */
    public function enviarTatc($tatc)
    {
        try {
            $payload = $this->prepararPayloadTatc($tatc);
            
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/tatc', $payload);

            $this->registrarRespuesta($tatc, $response, 'TATC');

            return $response;

        } catch (\Exception $e) {
            Log::error('Error enviando TATC a Hermes: ' . $e->getMessage(), [
                'tatc_id' => $tatc->id,
                'numero_tatc' => $tatc->numero_tatc
            ]);

            // Registrar error en el TATC
            $tatc->update([
                'hermes_status' => 'Error',
                'hermes_response' => ['error' => $e->getMessage()]
            ]);

            throw $e;
        }
    }

    /**
     * Enviar TSTC a la API de Hermes
     */
    public function enviarTstc($tstc)
    {
        try {
            $payload = $this->prepararPayloadTstc($tstc);
            
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/tstc', $payload);

            $this->registrarRespuesta($tstc, $response, 'TSTC');

            return $response;

        } catch (\Exception $e) {
            Log::error('Error enviando TSTC a Hermes: ' . $e->getMessage(), [
                'tstc_id' => $tstc->id,
                'numero_tstc' => $tstc->numero_tstc
            ]);

            // Registrar error en el TSTC
            $tstc->update([
                'hermes_status' => 'Error',
                'hermes_response' => ['error' => $e->getMessage()]
            ]);

            throw $e;
        }
    }

    /**
     * Preparar payload para TATC según especificación Hermes
     */
    protected function prepararPayloadTatc($tatc)
    {
        return [
            'numero_tatc' => $tatc->numero_tatc,
            'operador' => [
                'codigo' => $tatc->codigo_operador,
                'nombre' => $tatc->nombre_operador,
                'rut' => $tatc->rut_operador,
                'resolucion' => $tatc->resolucion_operador,
            ],
            'contenedor' => [
                'numero' => $tatc->numero_contenedor,
                'tipo' => $tatc->tipo_contenedor,
                'tara' => $tatc->tara_contenedor,
                'capacidad' => $tatc->capacidad_contenedor,
            ],
            'buque' => [
                'nombre' => $tatc->nombre_buque,
                'viaje' => $tatc->viaje_buque,
                'bandera' => $tatc->bandera_buque,
            ],
            'puertos' => [
                'origen' => $tatc->puerto_origen,
                'destino' => $tatc->puerto_destino,
                'arribo' => $tatc->puerto_arribo,
            ],
            'carga' => [
                'descripcion' => $tatc->descripcion_carga,
                'peso_bruto' => $tatc->peso_bruto,
                'cantidad_bultos' => $tatc->cantidad_bultos,
                'tipo_bultos' => $tatc->tipo_bultos,
            ],
            'consignatario' => [
                'nombre' => $tatc->nombre_consignatario,
                'rut' => $tatc->rut_consignatario,
                'direccion' => $tatc->direccion_consignatario,
            ],
            'transportista' => [
                'nombre' => $tatc->nombre_transportista,
                'rut' => $tatc->rut_transportista,
                'patente' => $tatc->patente_vehiculo,
            ],
            'deposito' => [
                'lugar' => $tatc->lugar_deposito,
                'direccion' => $tatc->direccion_deposito,
            ],
            'fechas' => [
                'arribo' => $tatc->fecha_arribo->format('Y-m-d'),
                'vencimiento' => $tatc->fecha_vencimiento->format('Y-m-d'),
                'retiro' => $tatc->fecha_retiro ? $tatc->fecha_retiro->format('Y-m-d') : null,
            ],
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * Preparar payload para TSTC según especificación Hermes
     */
    protected function prepararPayloadTstc($tstc)
    {
        return [
            'numero_tstc' => $tstc->numero_tstc,
            'operador' => [
                'codigo' => $tstc->codigo_operador,
                'nombre' => $tstc->nombre_operador,
                'rut' => $tstc->rut_operador,
                'resolucion' => $tstc->resolucion_operador,
            ],
            'contenedor' => [
                'numero' => $tstc->numero_contenedor,
                'tipo' => $tstc->tipo_contenedor,
                'tara' => $tstc->tara_contenedor,
                'capacidad' => $tstc->capacidad_contenedor,
            ],
            'buque' => [
                'nombre' => $tstc->nombre_buque,
                'viaje' => $tstc->viaje_buque,
                'bandera' => $tstc->bandera_buque,
            ],
            'puertos' => [
                'origen' => $tstc->puerto_origen,
                'destino' => $tstc->puerto_destino,
                'arribo' => $tstc->puerto_arribo,
            ],
            'carga' => [
                'descripcion' => $tstc->descripcion_carga,
                'peso_bruto' => $tstc->peso_bruto,
                'cantidad_bultos' => $tstc->cantidad_bultos,
                'tipo_bultos' => $tstc->tipo_bultos,
            ],
            'consignatario' => [
                'nombre' => $tstc->nombre_consignatario,
                'rut' => $tstc->rut_consignatario,
                'direccion' => $tstc->direccion_consignatario,
            ],
            'transportista' => [
                'nombre' => $tstc->nombre_transportista,
                'rut' => $tstc->rut_transportista,
                'patente' => $tstc->patente_vehiculo,
            ],
            'deposito' => [
                'lugar' => $tstc->lugar_deposito,
                'direccion' => $tstc->direccion_deposito,
            ],
            'fechas' => [
                'arribo' => $tstc->fecha_arribo->format('Y-m-d'),
                'vencimiento' => $tstc->fecha_vencimiento->format('Y-m-d'),
                'retiro' => $tstc->fecha_retiro ? $tstc->fecha_retiro->format('Y-m-d') : null,
            ],
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * Registrar respuesta de la API en el modelo
     */
    protected function registrarRespuesta($modelo, $response, $tipo)
    {
        $status = $response->successful() ? 'Enviado' : 'Error';
        $messageId = $response->json('message_id') ?? null;
        
        $modelo->update([
            'hermes_request' => $modelo->hermes_request,
            'hermes_response' => $response->json(),
            'hermes_status' => $status,
            'hermes_message_id' => $messageId,
            'hermes_sent_at' => now(),
            'hermes_processed_at' => $response->successful() ? now() : null,
        ]);

        Log::info("{$tipo} enviado a Hermes", [
            'modelo_id' => $modelo->id,
            'numero' => $modelo->numero_tatc ?? $modelo->numero_tstc,
            'status' => $status,
            'message_id' => $messageId,
            'response_code' => $response->status(),
        ]);
    }

    /**
     * Verificar estado de un TATC/TSTC en Hermes
     */
    public function verificarEstado($messageId, $tipo = 'TATC')
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->token,
                ])
                ->get($this->baseUrl . "/{$tipo}/status/{$messageId}");

            return $response->json();

        } catch (\Exception $e) {
            Log::error("Error verificando estado en Hermes: " . $e->getMessage());
            throw $e;
        }
    }
} 