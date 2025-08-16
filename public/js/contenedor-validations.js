/**
 * Validaciones específicas para el formulario de contenedores
 * Basado en las validaciones de Mitac
 */

$(document).ready(function() {
    
    // Input mask para Nº Contenedor: AAAA999999-9
    if ($("#numero_contenedor").length) {
        $("#numero_contenedor").inputmask("AAAA999999-9");
        
        // Validación al perder el foco
        $("#numero_contenedor").blur(function() {
            var nn = $(this).val().replace("_", "");
            
            if (nn.length != 12) {
                $(this).css("background-color", "#FD7F83");
                $("#btnAccion").attr('disabled', 'disabled');
            } else {
                $(this).css("background-color", "");
                $("#btnAccion").removeAttr('disabled');
            }
        });
    }
    
    // Input mask para Tara Contenedor: solo números, máximo 4 dígitos
    if ($("#tara_contenedor").length) {
        $("#tara_contenedor").inputmask("9999");
        
        // Validación adicional para Tara Contenedor
        $("#tara_contenedor").on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
        });
    }
    
    // Input mask para Año Fabricación: solo números, máximo 4 dígitos
    if ($("#anofab_contenedor").length) {
        $("#anofab_contenedor").inputmask("9999");
        
        // Validación adicional para Año Fabricación
        $("#anofab_contenedor").on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            if (this.value.length > 4) {
                this.value = this.value.slice(0, 4);
            }
            
            // Validar que sea un año válido (entre 1900 y año actual + 1)
            var year = parseInt(this.value);
            var currentYear = new Date().getFullYear();
            
            if (year < 1900 || year > currentYear + 1) {
                $(this).css("background-color", "#FD7F83");
            } else {
                $(this).css("background-color", "");
            }
        });
    }
    
    // Input mask para TATC: AAAA999999-9
    if ($("#tatc").length) {
        $("#tatc").inputmask("AAAA999999-9");
    }
    
    // Validación para RUT Factura (formato chileno)
    if ($("#rut_factura").length) {
        $("#rut_factura").on('input', function() {
            var rut = this.value.replace(/\./g, '').replace(/-/g, '');
            
            if (rut.length > 0) {
                // Validar formato básico de RUT chileno
                var rutRegex = /^[0-9]{7,8}[0-9kK]$/;
                if (!rutRegex.test(rut)) {
                    $(this).css("background-color", "#FD7F83");
                } else {
                    $(this).css("background-color", "");
                }
            } else {
                $(this).css("background-color", "");
            }
        });
    }
    
    // Validación para RUT Chofer (formato chileno)
    if ($("#rut_chofer").length) {
        $("#rut_chofer").on('input', function() {
            var rut = this.value.replace(/\./g, '').replace(/-/g, '');
            
            if (rut.length > 0) {
                // Validar formato básico de RUT chileno
                var rutRegex = /^[0-9]{7,8}[0-9kK]$/;
                if (!rutRegex.test(rut)) {
                    $(this).css("background-color", "#FD7F83");
                } else {
                    $(this).css("background-color", "");
                }
            } else {
                $(this).css("background-color", "");
            }
        });
    }
    
    // Validación para Patente Camión (formato chileno)
    if ($("#patente_camion").length) {
        $("#patente_camion").on('input', function() {
            var patente = this.value.toUpperCase();
            this.value = patente;
            
            // Formato: LLLL12 o LL1234
            var patenteRegex = /^[A-Z]{2,4}[0-9]{2,4}$/;
            
            if (patente.length > 0 && !patenteRegex.test(patente)) {
                $(this).css("background-color", "#FD7F83");
            } else {
                $(this).css("background-color", "");
            }
        });
    }
    
    // Validación para Valor Factura (solo números)
    if ($("#valor_factura").length) {
        $("#valor_factura").on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }
    
    // Validación para campos de fecha
    $('input[type="date"]').on('change', function() {
        var selectedDate = new Date(this.value);
        var today = new Date();
        
        // Para fecha de ingreso, no puede ser futura
        if (this.name === 'fecha_ingreso' && selectedDate > today) {
            $(this).css("background-color", "#FD7F83");
            alert('La fecha de ingreso no puede ser futura');
            this.value = '';
        } else {
            $(this).css("background-color", "");
        }
    });
    
    // Validación para campos de texto con longitud máxima
    $('input[maxlength]').on('input', function() {
        var maxLength = parseInt($(this).attr('maxlength'));
        if (this.value.length > maxLength) {
            this.value = this.value.slice(0, maxLength);
        }
    });
    
    // Validación para campos requeridos
    $('input[required], select[required]').on('blur', function() {
        if (!this.value.trim()) {
            $(this).css("background-color", "#FD7F83");
        } else {
            $(this).css("background-color", "");
        }
    });
    
    // Función para validar todo el formulario antes de enviar
    $('form').on('submit', function(e) {
        var isValid = true;
        
        // Validar campos requeridos
        $(this).find('input[required], select[required]').each(function() {
            if (!this.value.trim()) {
                $(this).css("background-color", "#FD7F83");
                isValid = false;
            }
        });
        
        // Validar Nº Contenedor específicamente
        var numeroContenedor = $("#numero_contenedor").val().replace("_", "");
        if (numeroContenedor.length !== 12) {
            $("#numero_contenedor").css("background-color", "#FD7F83");
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor, complete todos los campos requeridos correctamente.');
            return false;
        }
    });
    
    // Función para limpiar validaciones al cambiar de tab
    $('button[data-bs-toggle="tab"]').on('click', function() {
        $('input, select').css("background-color", "");
    });
    
    // Tooltips para campos con validaciones especiales
    if ($("#numero_contenedor").length) {
        $("#numero_contenedor").attr('title', 'Formato: AAAA999999-9 (4 letras + 6 números + guión + 1 dígito)');
    }
    
    if ($("#tara_contenedor").length) {
        $("#tara_contenedor").attr('title', 'Solo números, máximo 4 dígitos');
    }
    
    if ($("#anofab_contenedor").length) {
        $("#anofab_contenedor").attr('title', 'Año de fabricación (4 dígitos)');
    }
    
    if ($("#patente_camion").length) {
        $("#patente_camion").attr('title', 'Formato: LLLL12 o LL1234');
    }
    
    // Inicializar tooltips de Bootstrap
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});

/**
 * Función para validar RUT chileno
 */
function validarRut(rut) {
    // Eliminar puntos y guión
    rut = rut.replace(/\./g, '').replace(/-/g, '');
    
    // Validar formato básico
    if (!/^[0-9]{7,8}[0-9kK]$/.test(rut)) {
        return false;
    }
    
    // Obtener dígito verificador
    var dv = rut.slice(-1);
    var numero = rut.slice(0, -1);
    
    // Calcular dígito verificador
    var suma = 0;
    var multiplicador = 2;
    
    for (var i = numero.length - 1; i >= 0; i--) {
        suma += parseInt(numero[i]) * multiplicador;
        multiplicador = multiplicador === 7 ? 2 : multiplicador + 1;
    }
    
    var dvCalculado = 11 - (suma % 11);
    var dvEsperado = dvCalculado === 11 ? '0' : dvCalculado === 10 ? 'K' : dvCalculado.toString();
    
    return dv.toUpperCase() === dvEsperado;
}
