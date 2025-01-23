
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
let chartMonto = null;
function initChartMonto(ctx, descripciones, balanza_no1, balanza_no2)
{
    const data = balanza_no1;
    const data2 = balanza_no2;

    const helpers = Chart.helpers;
    let easingOut = helpers.easingEffects.easeOutQuart;
    let easingIn = helpers.easingEffects.easeInQuint;
    let restart = false;
    const totalDuration = 5000;
    const durationX = (ctx) => easingOut(ctx.index / data.length) * totalDuration / data.length;
    const delayX = (ctx) => easingOut(ctx.index / data.length) * totalDuration;
    const durationY = (ctx) => easingIn(ctx.index / data2.length) * totalDuration / data2.length;
    const delayY = (ctx) => easingIn(ctx.index / data2.length) * totalDuration;
    const previousY = (ctx) => ctx.index === 0 ? ctx.chart.scales.y.getPixelForValue(100) : ctx.chart.getDatasetMeta(ctx.datasetIndex).data[ctx.index - 1].getProps(['y'], true).y;
    const animation = {
        x: {
            type: 'number',
            easing: 'linear',
            duration: durationX,
            from: NaN, // the point is initially skipped
            delay(ctx) {
            if (ctx.type !== 'data' || ctx.xStarted) {
                return 0;
            }
            ctx.xStarted = true;
            return delayX(ctx);
            }
        },
        y: {
            type: 'number',
            easing: 'linear',
            duration: durationY,
            from: previousY,
            delay(ctx) {
            if (ctx.type !== 'data2' || ctx.yStarted) {
                return 0;
            }
            ctx.yStarted = true;
            return delayY(ctx);
            }
        }
    };

    if(chartMonto){
        chartMonto.destroy();
    }

    chartMonto = new Chart(ctx, {
        type: 'line',
        data: {
          label: descripciones,
          labels: descripciones,
          datasets: [{
            label: 'Balanza No1',
            borderColor: Utils.CHART_COLORS.blue,
            data: balanza_no1,
            borderWidth: 1,
            radius: 0,
          },
          {
            label: 'Balanza No2',
            borderColor: Utils.CHART_COLORS.red,
            data: balanza_no2,
            borderWidth: 1,
            radius: 0,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation,
          parsing: false,
          interaction: {
            mode: 'nearest',
            axis: 'x',
            intersect: false
          },
          plugins: {
            legend: true,
            decimation: {
                enabled: false,
                algorithm: 'min-max',
            },
            title: {
              display: true,
              text: 'Gráfica de muestreo / montos'
            },
            tooltip: {
                usePointStyle: true,
                callbacks: {
                    title: function(context){
                        const cont = context[0];
                        const labelIndex = (cont.datasetIndex * 2) + cont.dataIndex;
                        const titleText = cont.chart.data.labels[labelIndex];
                        return [titleText];
                    },
                    label: function(context) {
                        const preLabel = (context.datasetIndex == 0) ? 'Monto inicial' : 'Monto final';
                        const labelText  = preLabel + ': ' + context.formattedValue;
                        return [labelText];
                    },
                    footer: function(context) {
                        const dataset_1 = context[0].raw.y;
                        const dataset_2 = context[1].raw.y; // raw.y
                        const suma = dataset_1 + dataset_2;
                        return ['Monto total: ' + suma.toLocaleString()];
                    },
                }
            }
          },
          scales: {
            x: {
              type: 'linear'
            }
          }
        }
      });
}

function updateChartMonto(newDescripciones, newBalanza_no1, newBalanza_no2) {
    if (chartMonto) {
        chartMonto.data.labels = newDescripciones;
        chartMonto.data.datasets[0].data = newBalanza_no1;
        chartMonto.data.datasets[1].data = newBalanza_no2;
        chartMonto.update();
    }
}
