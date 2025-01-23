
/**
 * The function `initChartMonto` initializes a line chart with two datasets and custom animations based
 * on provided initial and final data.
 * @param ctx - The `ctx` parameter in the `initChartMonto` function represents the context of the
 * chart where it will be rendered. It typically refers to the 2D rendering context of the canvas
 * element where the chart will be drawn. This context is necessary for drawing and interacting with
 * the chart within the
 * @param balanza_no1 - It looks like you were about to provide some information about the
 * `balanza_no1` parameter. How can I assist you with that?
 * @param balanza_no2 - It looks like you were about to provide some information about the
 * `balanza_no2` parameter, but the message got cut off. Could you please provide more details or
 * let me know if you need help with something specific related to `balanza_no2`?
 * @returns The `initChartMonto` function initializes a line chart using Chart.js library with two
 * datasets (`balanza_no1` and `balanza_no2`). The chart has animations for x and y axes, with
 * easing effects and durationX specified. The chart also has options for interaction, plugins, legend,
 * title, and scales.
 */
function initChartMontoBar(ctx, descripciones, balanza_no1, balanza_no2)
{

    new Chart(ctx, {
        type: 'bar',
        data: {
          labels: descripciones,
          datasets: [{
                borderColor: Utils.CHART_COLORS.blue,
                data: balanza_no1,
                borderWidth: 1,
                radius: 0,
            },
            {
                borderColor: Utils.CHART_COLORS.red,
                data: balanza_no2,
                borderWidth: 1,
                radius: 0,
            }]
        },
        options: {
            responsive: true,
            plugins: {
              legend:  false,
              label: false,
              title: {
                display: true,
                text: 'Gráfica de muestreo / montos'
              }
            },
          }
    });

}
