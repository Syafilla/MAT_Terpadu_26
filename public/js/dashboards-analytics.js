/**
 * Dashboard Analytics
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  let cardColor, headingColor, legendColor, labelColor, shadeColor, borderColor, fontFamily;
  cardColor = config.colors.cardColor;
  headingColor = config.colors.headingColor;
  legendColor = config.colors.bodyColor;
  labelColor = config.colors.textMuted;
  borderColor = config.colors.borderColor;
  fontFamily = config.fontFamily;

  // Order Area Chart
  // --------------------------------------------------------------------
  const orderAreaChartEl = document.querySelector('#orderChart'),
    orderAreaChartConfig = {
      chart: {
        height: 80,
        type: 'area',
        toolbar: {
          show: false
        },
        sparkline: {
          enabled: true
        }
      },
      markers: {
        size: 6,
        colors: 'transparent',
        strokeColors: 'transparent',
        strokeWidth: 4,
        discrete: [
          {
            fillColor: cardColor,
            seriesIndex: 0,
            dataPointIndex: 6,
            strokeColor: config.colors.success,
            strokeWidth: 2,
            size: 6,
            radius: 8
          }
        ],
        offsetX: -1,
        hover: {
          size: 7
        }
      },
      grid: {
        show: false,
        padding: {
          top: 15,
          right: 7,
          left: 0
        }
      },
      colors: [config.colors.success],
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.4,
          gradientToColors: [config.colors.cardColor],
          opacityTo: 0.4,
          stops: [0, 100]
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        width: 2,
        curve: 'smooth'
      },
      series: [
        {
          data: [180, 175, 275, 140, 205, 190, 295]
        }
      ],
      xaxis: {
        show: false,
        lines: {
          show: false
        },
        labels: {
          show: false
        },
        stroke: {
          width: 0
        },
        axisBorder: {
          show: false
        }
      },
      yaxis: {
        stroke: {
          width: 0
        },
        show: false
      }
    };
  if (typeof orderAreaChartEl !== undefined && orderAreaChartEl !== null) {
    const orderAreaChart = new ApexCharts(orderAreaChartEl, orderAreaChartConfig);
    orderAreaChart.render();
  }
  // Growth Chart - Radial Bar Chart
  // --------------------------------------------------------------------
  const growthChartEl = document.querySelector('#growthChart');
  const isPositive = persentase >= 0;
  const chartColor = isPositive ? '#28c76f' : '#ea5455';

  const growthChartOptions = {
    series: [Math.abs(persentase)],
    labels: ['Pertumbuhan'],
    chart: {
      height: 200,
      type: 'radialBar'
    },
    plotOptions: {
      radialBar: {
        size: 150,
        offsetY: 10,
        startAngle: -150,
        endAngle: 150,
        hollow: {
          size: '55%'
        },
        track: {
          background: cardColor,
          strokeWidth: '100%'
        },
        dataLabels: {
          name: {
            offsetY: 15,
            color: legendColor,
            fontSize: '15px',
            fontWeight: '500',
            fontFamily: fontFamily
          },
          value: {
            offsetY: -25,
            color: headingColor,
            fontSize: '22px',
            fontWeight: '500',
            fontFamily: fontFamily,
            formatter: function (val) {
              return val + '%';
            }
          }
        }
      }
    },
    colors: [chartColor],
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        shadeIntensity: 0.5,
        gradientToColors: [chartColor],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 0.6,
        stops: [30, 70, 100]
      }
    },
    stroke: {
      dashArray: 5
    },
    grid: {
      padding: {
        top: -35,
        bottom: -10
      }
    },
    states: {
      hover: {
        filter: {
          type: 'none'
        }
      },
      active: {
        filter: {
          type: 'none'
        }
      }
    }
  };

  if (typeof growthChartEl !== 'undefined' && growthChartEl !== null) {
    const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
    growthChart.render();
  }

  const totalNow = weeklyNow;
  const totalLast = weeklyLast || 1; // cegah pembagian nol

  const orderPercentChange = Math.round(((totalNow - totalLast) / totalLast) * 100);
  const orderIsPositive = orderPercentChange >= 0;
  const orderChartColor = orderIsPositive ? '#28c76f' : '#ea5455';

  // total arsip minggu ini
  document.querySelector('#totalArsip').innerText = totalNow.toLocaleString();

  const chartOrderStatistics = document.querySelector('#orderStatisticsChart');

  const orderChartConfig = {
    chart: {
      height: 165,
      width: 136,
      type: 'donut'
    },
    series: [
      Math.abs(orderPercentChange),
      100 - Math.abs(orderPercentChange)
    ],
    labels: ['Perubahan', 'Sisa'],
    colors: [orderChartColor, cardColor],
    stroke: {
      width: 5,
      colors: [cardColor]
    },
    legend: { show: false },
    dataLabels: { enabled: false },
    plotOptions: {
      pie: {
        donut: {
          size: '75%',
          labels: {
            show: true,
            value: {
              fontSize: '18px',
              fontFamily: fontFamily,
              fontWeight: 600,
              formatter: () => orderPercentChange + '%'
            },
            name: {
              offsetY: 20,
              formatter: () => 'Per Minggu'
            }
          }
        }
      }
    }
  };

  if (chartOrderStatistics) {
    new ApexCharts(chartOrderStatistics, orderChartConfig).render();
  }

  // =======================
  // LIST PETUGAS
  // =======================
  const petugasList = document.querySelector('#petugasList');
  petugasList.innerHTML = '';

  petugasData.forEach(p => {
    petugasList.insertAdjacentHTML('beforeend', `
    <li class="d-flex align-items-center mb-4">
      <div class="avatar flex-shrink-0 me-3">
        <span class="avatar-initial rounded bg-label-primary">
          <i class="icon-base bx bx-user"></i>
        </span>
      </div>
      <div class="d-flex w-100 justify-content-between">
        <div>
          <h6 class="mb-0">${p.name}</h6>
          <small>Input Mingguan</small>
        </div>
        <h6 class="mb-0">${p.total}</h6>
      </div>
    </li>
  `);
  });

});
