<template>
    <div class="dashboard">
        <h1 class="dash-title">Click Tracking Overview</h1>
        <div class="horizontal"></div>

        <div class="dash-details">
            <div class="dash-item">
                <div class="left-item">
                    <h1>49</h1>
                    <p>total Click</p>
                </div>
                <div class="right-item">
                    <div class="icon">
                        <Icon icon="tm-eye" />
                    </div>
                </div>
            </div>
            <div class="dash-item">
                <div class="left-item">
                    <h1>49</h1>
                    <p>total Click</p>
                </div>
                <div class="right-item">
                    <div class="icon">
                        <Icon icon="tm-eye" />
                    </div>
                </div>
            </div>
            <div class="dash-item">
                <div class="left-item">
                    <h1>49</h1>
                    <p>total Click</p>
                </div>
                <div class="right-item">
                    <div class="icon">
                        <Icon icon="tm-eye" />
                    </div>
                </div>
            </div>
            <div class="dash-item">
                <div class="left-item">
                    <h1>49</h1>
                    <p>total Click</p>
                </div>
                <div class="right-item">
                    <div class="icon">
                        <Icon icon="List" />
                    </div>.

                </div>
            </div>

        </div>

    </div>

    <div class="dash-overview ">
        <div class="integration">
            <h1 class="dash-title">Integration</h1>
            <div class="horizontal"></div>
            <div class="chart">
                <div>
                    <canvas id="myChart"></canvas>
                </div>

            </div>
        </div>
        <div class="affiliate">
            <h1 class="dash-title">Affiliate Statistic</h1>
            <div class="horizontal"></div>

        </div>
    </div>


</template>

<script>
import Icon from '../../Icons/Index.vue';
import { Chart } from 'chart.js';

export default {
    components: {
        Icon
    },
    mounted() {
        const ctx = document.getElementById('myChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1,
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
};
</script>