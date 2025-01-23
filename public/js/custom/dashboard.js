function fncChartDona(ElementId, Porcent, ElementBgColor) {
    var progress = Porcent;
    new Chart(document.getElementById(ElementId), {
        type: 'doughnut',
        data: {
            labels: ['Progreso', 'Sin progreso'],
            datasets: [{
                data: [progress, 100 - progress], // Porcentaje de progreso y porcentaje restante
                backgroundColor: [ElementBgColor, 'rgba(192, 192, 192, 1)'] // Rojo encima de gris
            }]
        },
        options: {
            cutout: '80%',
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false,
                    text: 'Círculo de Progreso con Radio'
                }
            }
        },
        plugins: [{
            id: 'textCenter',
            beforeDraw: function (chart, a, b) {
                var width = chart.width,
                    height = chart.height,
                    ctx = chart.ctx;

                ctx.restore();
                var fontSize = (2).toFixed(2);
                ctx.textAlign = 'middle';
                ctx.textBaseline = 'middle';
                ctx.font = fontSize + "em sans-serif";
                ctx.fillStyle = 'black'; // Color del texto en el centro de la dona

                var text = progress + "%",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2 + 5;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }]
    });
}
