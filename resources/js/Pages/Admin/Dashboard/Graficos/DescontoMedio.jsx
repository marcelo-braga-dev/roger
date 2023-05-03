import {Bar} from "react-chartjs-2";
import React from "react";

export default function DescontoMedio({dados}) {

    const nomes = dados?.tabela?.map((item) => {
        return  item.gerente
    })
    const vendas = dados?.tabela?.map((item) => {
        return  item.media * 100
    })

    const data = {
        labels: nomes,
        datasets: [
            {
                label: "Média",
                backgroundColor: "rgba(234,145,11,0.60)",
                data: vendas,
            }
        ],
    };

    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false,
                text: 'Status dos atendimentos',
            },
        },
    };

    return (
        <Bar options={options} data={data}/>
    )
}
