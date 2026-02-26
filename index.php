<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Costos SaaS (COP)</title>
    <!-- Librería para generar PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
            margin: 20px;
            padding: 20px;
            color: #1e2b3a;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 25px;
        }
        h1 {
            text-align: center;
            color: #0b4f6c;
            margin-bottom: 30px;
            border-bottom: 2px solid #0b4f6c;
            padding-bottom: 10px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .card {
            background-color: #f9fbfd;
            border: 1px solid #d0ddee;
            border-radius: 10px;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .card h2 {
            font-size: 1.2rem;
            margin-top: 0;
            margin-bottom: 15px;
            color: #145c7a;
            border-left: 4px solid #2a9d8f;
            padding-left: 10px;
        }
        .campo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 0.95rem;
        }
        .campo label {
            font-weight: 500;
            color: #2c3e50;
        }
        .campo input, .campo span {
            border: 1px solid #bdc9d9;
            border-radius: 5px;
            padding: 5px 8px;
            width: 110px;
            text-align: right;
            background-color: white;
        }
        .campo input:focus {
            outline: none;
            border-color: #2a9d8f;
            box-shadow: 0 0 0 2px rgba(42,157,143,0.2);
        }
        .campo span {
            background-color: #eef2f6;
            font-weight: 600;
            color: #0b4f6c;
        }
        .total-destacado {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            font-weight: bold;
        }
        .tabla-planes {
            margin-top: 25px;
            background-color: #eef2f6;
            border-radius: 8px;
            padding: 15px;
        }
        .tabla-planes h3 {
            margin-top: 0;
            color: #0b4f6c;
        }
        .fila-planes {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            font-weight: 600;
            border-bottom: 1px solid #b0c4d9;
            padding: 8px 0;
        }
        .fila-planes div {
            text-align: center;
        }
        .resultado-plan {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            padding: 5px 0;
            border-bottom: 1px dashed #b0c4d9;
        }
        .resultado-plan div {
            text-align: center;
        }
        .btn-pdf {
            background-color: #0b4f6c;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 1.1rem;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 20px;
            display: inline-block;
            transition: background-color 0.2s;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .btn-pdf:hover {
            background-color: #083d54;
        }
        .footer {
            margin-top: 25px;
            font-size: 0.85rem;
            text-align: right;
            color: #6c7a8d;
            border-top: 1px solid #d0ddee;
            padding-top: 15px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📊 Calculadora de Costos SaaS ,  </h1>

    <div class="grid">
        <!-- Columna 1: Costo Desarrollo Inicial + Infraestructura + Mantenimiento -->
        <div>
            <div class="card">
                <h2>🚀 Desarrollo Inicial</h2>
                <div class="campo">
                    <label>Total desarrollo:</label>
                    <input type="number" id="costo_desarrollo" value="4000000" step="100000">
                </div>
                <div class="campo">
                    <label>Meses recuperación:</label>
                    <input type="number" id="meses_recuperacion" value="24" step="1" min="1">
                </div>
                <div class="campo total-destacado">
                    <label>💸 Mensual desarrollo:</label>
                    <span id="mensual_desarrollo">0</span>
                </div>
            </div>
            <div class="card">
                <h2>🖥️ Infraestructura</h2>
                <div class="campo">
                    <label>Servidor VPS:</label>
                    <input type="number" id="vps" value="80000" step="1000">
                </div>
                <div class="campo">
                    <label>Otros (CDN, BD, etc):</label>
                    <input type="number" id="infra_otros" value="0" step="1000">
                </div>
                <div class="campo total-destacado">
                    <label>Total infraestructura:</label>
                    <span id="total_infraestructura">0</span>
                </div>
            </div>
            <div class="card">
                <h2>🛠️ Mantenimiento y Soporte</h2>
                <div class="campo">
                    <label>Cantidad de horas:</label>
                    <input type="number" id="horas_soporte" value="3" step="0.5">
                </div>
                <div class="campo">
                    <label>Precio por hora (COP):</label>
                    <input type="number" id="precio_hora" value="8000" step="1000">
                </div>
                <div class="campo total-destacado">
                    <label>Total soporte:</label>
                    <span id="total_soporte">0</span>
                </div>
            </div>
        </div>

        <!-- Columna 2: Clientes + Costo Base + Margen + Costos Extras -->
        <div>
            <div class="card">
                <h2>👥 Clientes Actuales</h2>
                <div class="campo">
                    <label>Fecha:</label>
                    <input type="date" id="fecha_clientes" value="2026-02-01">
                </div>
                <div class="campo">
                    <label>Cantidad de clientes:</label>
                    <input type="number" id="cantidad_clientes" value="10" step="1" min="1">
                </div>
            </div>
            <div class="card">
                <h2>💰 Costo Base por Cliente</h2>
                <div class="campo">
                    <label>Base = (Desarrollo mes + Infra) / clientes + Soporte</label>
                    <span id="costo_base" style="width: 140px;">0</span>
                </div>
                <div class="campo">
                    <label>Margen (%):</label>
                    <input type="number" id="porcentaje_margen" value="40" step="1" min="0"> <span style="margin-left:5px;">%</span>
                </div>
                <div class="campo">
                    <label>Valor margen:</label>
                    <span id="valor_margen">0</span>
                </div>
                <div class="campo total-destacado">
                    <label>Total con margen:</label>
                    <span id="total_con_margen">0</span>
                </div>
            </div>
            <div class="card">
                <h2>➕ Costos Extras</h2>
                <div class="campo">
                    <label>Horas extras:</label>
                    <span id="horas_extras_totales">0</span>
                </div>
                <div class="campo">
                    <label>Otros extras:</label>
                    <input type="number" id="otros_extras" value="0" step="1000">
                </div>
                <div class="campo total-destacado">
                    <label>Total extras:</label>
                    <span id="total_extras">0</span>
                </div>
            </div>
        </div>

        <!-- Columna 3: Costos Variables por Plan + Redondeo + Resultados -->
        <div>
            <div class="card">
                <h2>📦 Costos Variables por </h2>
                <div class="campo">
                    <label>Plan Básico:</label>
                    <input type="number" id="plan_basico" value="10000" step="1000">
                </div>
                <div class="campo">
                    <label>Plan Intermedio:</label>
                    <input type="number" id="plan_intermedio" value="25000" step="1000">
                </div>
                <div class="campo">
                    <label>Plan Pro:</label>
                    <input type="number" id="plan_pro" value="50000" step="1000">
                </div>
                <div class="campo">
                    <label>Plan Enterprise:</label>
                    <input type="number" id="plan_enterprise" value="150000" step="1000">
                </div>
            </div>
            <div class="card">
                <h2>⏳ Horas Extras</h2>
                <div class="campo">
                    <label>Cantidad horas extra:</label>
                    <input type="number" id="horas_extra_cant" value="0" step="1">
                </div>
                <div class="campo">
                    <label>Precio por hora extra:</label>
                    <input type="number" id="precio_hora_extra" value="12000" step="1000">
                </div>
                <div class="campo total-destacado">
                    <label>Total horas extra:</label>
                    <span id="total_horas_extra">0</span>
                </div>
            </div>
            <div class="card">
                <h2>🧾 Redondeo por Plan</h2>
                <div class="campo">
                    <label>Redondeo básico:</label>
                    <span id="redondeo_basico">0</span>
                </div>
                <div class="campo">
                    <label>Redondeo intermedio:</label>
                    <span id="redondeo_intermedio">0</span>
                </div>
                <div class="campo">
                    <label>Redondeo pro:</label>
                    <span id="redondeo_pro">0</span>
                </div>
                <div class="campo">
                    <label>Redondeo enterprise:</label>
                    <span id="redondeo_enterprise">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de resultados mensuales por plan -->
    <div class="tabla-planes">
        <h3>📋 Costo Mensual por Plan (COP) </h3>
        <div class="fila-planes">
            <div>Plan</div>
            <div>Base + Margen</div>
            <div>+ Variable</div>
            <div>+ Extras</div>
            <div>Total Mensual</div>
        </div>
        <div class="resultado-plan" id="res_basico">
            <div>Básico</div>
            <div id="basico_base">0</div>
            <div id="basico_var">0</div>
            <div id="basico_extra">0</div>
            <div id="basico_total">0</div>
        </div>
        <div class="resultado-plan" id="res_intermedio">
            <div>Intermedio</div>
            <div id="intermedio_base">0</div>
            <div id="intermedio_var">0</div>
            <div id="intermedio_extra">0</div>
            <div id="intermedio_total">0</div>
        </div>
        <div class="resultado-plan" id="res_pro">
            <div>Pro</div>
            <div id="pro_base">0</div>
            <div id="pro_var">0</div>
            <div id="pro_extra">0</div>
            <div id="pro_total">0</div>
        </div>
        <div class="resultado-plan" id="res_enterprise">
            <div>Enterprise</div>
            <div id="enterprise_base">0</div>
            <div id="enterprise_var">0</div>
            <div id="enterprise_extra">0</div>
            <div id="enterprise_total">0</div>
        </div>
    </div>

    <!-- Botón para generar PDF tipo factura -->
    <div class="text-center">
        <button class="btn-pdf" id="btnGenerarPDF">📄 Generar PDF </button>
    </div>

    <div class="footer">
       Hector jose chamorro nuñez .
    </div>
</div>

<script>
    function actualizarCalculos() {
        // ---- Obtener valores de los inputs ----
        const costoDesarrollo = parseFloat(document.getElementById('costo_desarrollo').value) || 0;
        const mesesRecup = parseFloat(document.getElementById('meses_recuperacion').value) || 1;
        const vps = parseFloat(document.getElementById('vps').value) || 0;
        const infraOtros = parseFloat(document.getElementById('infra_otros').value) || 0;
        const horasSoporte = parseFloat(document.getElementById('horas_soporte').value) || 0;
        const precioHora = parseFloat(document.getElementById('precio_hora').value) || 0;
        const cantidadClientes = parseFloat(document.getElementById('cantidad_clientes').value) || 1;
        const porcentajeMargen = parseFloat(document.getElementById('porcentaje_margen').value) || 0;
        const otrosExtras = parseFloat(document.getElementById('otros_extras').value) || 0;
        const planVarBas = parseFloat(document.getElementById('plan_basico').value) || 0;
        const planVarInt = parseFloat(document.getElementById('plan_intermedio').value) || 0;
        const planVarPro = parseFloat(document.getElementById('plan_pro').value) || 0;
        const planVarEnt = parseFloat(document.getElementById('plan_enterprise').value) || 0;
        const horasExtraCant = parseFloat(document.getElementById('horas_extra_cant').value) || 0;
        const precioHoraExtra = parseFloat(document.getElementById('precio_hora_extra').value) || 0;

        // ---- Cálculos internos ----
        const mensualDesarrollo = costoDesarrollo / mesesRecup;
        const totalInfra = vps + infraOtros;
        const totalSoporte = horasSoporte * precioHora;
        const totalHorasExtra = horasExtraCant * precioHoraExtra;

        // Costo base por cliente (fórmula original)
        const costoBaseCliente = ( (mensualDesarrollo + totalInfra) / cantidadClientes ) + totalSoporte;

        // Margen en pesos
        const valorMargen = costoBaseCliente * (porcentajeMargen / 100);
        const totalConMargen = costoBaseCliente + valorMargen;

        // Total Extras
        const totalExtras = totalHorasExtra + otrosExtras;

        // ---- Resultados por plan ----
        const baseMasMargen = totalConMargen;

        // Totales antes de redondeo
        const totalBasicoSinRedon = baseMasMargen + planVarBas + totalExtras;
        const totalIntermedSinRedon = baseMasMargen + planVarInt + totalExtras;
        const totalProSinRedon = baseMasMargen + planVarPro + totalExtras;
        const totalEnterpriseSinRedon = baseMasMargen + planVarEnt + totalExtras;

        // Redondeo (hacia arriba)
        const redondeoBas = Math.ceil(totalBasicoSinRedon);
        const redondeoInt = Math.ceil(totalIntermedSinRedon);
        const redondeoPro = Math.ceil(totalProSinRedon);
        const redondeoEnt = Math.ceil(totalEnterpriseSinRedon);

        // Totales con redondeo
        const totalBasico = redondeoBas;
        const totalIntermedio = redondeoInt;
        const totalPro = redondeoPro;
        const totalEnterprise = redondeoEnt;

        // ---- Actualizar campos de texto ----
        function formatearPesos(valor) {
            return Math.round(valor).toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        document.getElementById('mensual_desarrollo').innerText = formatearPesos(mensualDesarrollo);
        document.getElementById('total_infraestructura').innerText = formatearPesos(totalInfra);
        document.getElementById('total_soporte').innerText = formatearPesos(totalSoporte);
        document.getElementById('total_horas_extra').innerText = formatearPesos(totalHorasExtra);
        document.getElementById('costo_base').innerText = formatearPesos(costoBaseCliente);
        document.getElementById('valor_margen').innerText = formatearPesos(valorMargen);
        document.getElementById('total_con_margen').innerText = formatearPesos(totalConMargen);
        document.getElementById('horas_extras_totales').innerText = formatearPesos(totalHorasExtra);
        document.getElementById('total_extras').innerText = formatearPesos(totalExtras);

        document.getElementById('redondeo_basico').innerText = formatearPesos(redondeoBas);
        document.getElementById('redondeo_intermedio').innerText = formatearPesos(redondeoInt);
        document.getElementById('redondeo_pro').innerText = formatearPesos(redondeoPro);
        document.getElementById('redondeo_enterprise').innerText = formatearPesos(redondeoEnt);

        // Tabla de resultados
        document.getElementById('basico_base').innerText = formatearPesos(baseMasMargen);
        document.getElementById('basico_var').innerText = formatearPesos(planVarBas);
        document.getElementById('basico_extra').innerText = formatearPesos(totalExtras);
        document.getElementById('basico_total').innerText = formatearPesos(totalBasico);

        document.getElementById('intermedio_base').innerText = formatearPesos(baseMasMargen);
        document.getElementById('intermedio_var').innerText = formatearPesos(planVarInt);
        document.getElementById('intermedio_extra').innerText = formatearPesos(totalExtras);
        document.getElementById('intermedio_total').innerText = formatearPesos(totalIntermedio);

        document.getElementById('pro_base').innerText = formatearPesos(baseMasMargen);
        document.getElementById('pro_var').innerText = formatearPesos(planVarPro);
        document.getElementById('pro_extra').innerText = formatearPesos(totalExtras);
        document.getElementById('pro_total').innerText = formatearPesos(totalPro);

        document.getElementById('enterprise_base').innerText = formatearPesos(baseMasMargen);
        document.getElementById('enterprise_var').innerText = formatearPesos(planVarEnt);
        document.getElementById('enterprise_extra').innerText = formatearPesos(totalExtras);
        document.getElementById('enterprise_total').innerText = formatearPesos(totalEnterprise);
    }

    // Función para generar PDF tipo factura (SOLO Plan y Total Mensual)
    function generarPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Título
        doc.setFontSize(18);
        doc.setTextColor(11, 79, 108);
        doc.text('Factura de Costos SaaS', 14, 20);
        
        // Fecha
        const fecha = document.getElementById('fecha_clientes').value;
        doc.setFontSize(10);
        doc.setTextColor(100);
        doc.text(`Fecha: ${fecha}`, 14, 30);

        // SOLO Total desarrollo
        doc.setFontSize(12);
        doc.setTextColor(0);
        doc.text('Resumen:', 14, 45);
        
        const costoDesarrollo = document.getElementById('costo_desarrollo').value;
        doc.setFontSize(10);
        doc.text(`Total desarrollo: $ ${parseFloat(costoDesarrollo).toLocaleString('es-CO')} COP`, 14, 55);

        // Tabla de planes (SOLO con Plan y Total Mensual)
        const planes = [
            ['Básico', document.getElementById('basico_total').innerText],
            ['Intermedio', document.getElementById('intermedio_total').innerText],
            ['Pro', document.getElementById('pro_total').innerText],
            ['Enterprise', document.getElementById('enterprise_total').innerText]
        ];

        doc.autoTable({
            startY: 70,
            head: [['Plan', 'Total Mensual']],
            body: planes,
            theme: 'striped',
            headStyles: { fillColor: [11, 79, 108] },
            styles: { fontSize: 11, cellPadding: 4 },
            columnStyles: {
                0: { cellWidth: 50 },
                1: { cellWidth: 50, halign: 'right' }
            }
        });

        // Nota adicional
        const finalY = doc.lastAutoTable.finalY + 10;
        doc.setFontSize(8);
        doc.setTextColor(150);
        doc.text('* Todos los valores están en Pesos Colombianos (COP).', 14, finalY);
        doc.text('Generado desde Calculadora TodoCode.', 14, finalY + 5);

        // Guardar PDF
        doc.save('factura_costos_saas.pdf');
    }

    // Asignar eventos
    window.onload = function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', actualizarCalculos);
        });
        actualizarCalculos();

        document.getElementById('btnGenerarPDF').addEventListener('click', generarPDF);
    };
</script>
</body>
</html>