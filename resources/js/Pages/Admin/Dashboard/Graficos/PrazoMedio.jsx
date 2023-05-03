import {Bar} from "react-chartjs-2";
import React from "react";

export default function PrazoMedio({dados}) {

    const nomes = dados?.tabela?.map((item) => {
        return  item.gerente
    })
    const vendas = dados?.tabela?.map((item) => {
        return  item.prazo
    })

    const data = {
        labels: nomes,
        datasets: [
            {
                label: "Média",
                backgroundColor: "rgba(59,189,13,0.6)",
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
