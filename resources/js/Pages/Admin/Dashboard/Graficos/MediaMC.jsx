import {Bar} from "react-chartjs-2";
import React from "react";

export default function MediaMC({dados}) {

    const nomes = dados?.tabela?.map((item) => {
        return  item.vendedor
    })
    const vendas = dados?.tabela?.map((item) => {
        return  item.mc_taxa * 100
    })

    const data = {
        labels: nomes,
        datasets: [
            {
                label: "Média",
                backgroundColor: "rgba(24,52,169,0.6)",
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

// import {useEffect, useState} from "react";
//
// export default function MediaMC({dados}) {
//     const [col1, setCol1] = useState([]);
//     const [col2, setCol2] = useState([]);
//     const [col3, setCol3] = useState([]);
//     const [col4, setCol4] = useState([]);
//     const [col5, setCol5] = useState([]);
//
//     useEffect(() => {
//         dados?.tabela ?
//             setCol1(['1', dados?.tabela[0]?.mc_taxa * 100])
//             : ''
//         dados?.tabela ?
//             setCol2(['2', dados?.tabela[1]?.mc_taxa * 100])
//             : ''
//         dados?.tabela ?
//             setCol3(['3', dados?.tabela[2]?.mc_taxa * 100])
//             : ''
//         dados?.tabela ?
//             setCol4(['4', dados?.tabela[3]?.mc_taxa * 100])
//             : ''
//         dados?.tabela ?
//             setCol5(['5', dados?.tabela[4]?.mc_taxa * 100])
//             : ''
//     }, [dados]);
//
//     google.charts.load('current', {'packages': ['bar']});
//     google.charts.setOnLoadCallback(drawChart);
//
//     function drawChart() {
//         var data = google.visualization.arrayToDataTable([
//             ['Média MC', '%'],
//             col1,
//             col2,
//             col3,
//             col4,
//             col5,
//         ]);
//
//         var options = {
//             chart: {
//                 title: 'Média MC',
//             },
//             legend: {position: 'none'},
//             alignment: 'end'
//         };
//
//         var chart = new google.charts.Bar(document.getElementById('media_mc'));
//
//         chart.draw(data, google.charts.Bar.convertOptions(options));
//     }
//
//     return (
//         col1.length ?
//             <div className="row mb-5 border-bottom">
//                 <div className="col-md-6 mb-3">
//                     <div id="media_mc" style={{width: '100%', height: 350}}></div>
//                 </div>
//                 <div className="col-md-6 mb-3">
//                     <h6>Clientes:</h6>
//                     <ul>
//                         {/*<li><b>1 -</b> {dados?.tabela[0]?.cliente}</li>*/}
//                         {/*<li><b>2 -</b> {dados?.tabela[1]?.cliente}</li>*/}
//                         {/*<li><b>3 -</b> {dados?.tabela[2]?.cliente}</li>*/}
//                         {/*<li><b>4 -</b> {dados?.tabela[3]?.cliente}</li>*/}
//                         {/*<li><b>5 -</b> {dados?.tabela[4]?.cliente}</li>*/}
//                     </ul>
//                 </div>
//             </div> : ''
//     )
// }
