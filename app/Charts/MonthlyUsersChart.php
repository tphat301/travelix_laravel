<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyUsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        return $this->chart->lineChart()
            ->setTitle('Thống kê dịch vụ trong năm 2023.')
            // ->setSubtitle('Physical sales vs Digital sales.')
            ->addData('Dịch vụ vật lý', [40, 93, 35, 42, 18, 82])
            ->addData('Dịch vụ kỹ thuật số', [70, 29, 77, 28, 55, 45])
            ->setGrid('#fafafa', 0.1)
            ->setFontColor('#fff')
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setXAxis(['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12']);
    }
}
