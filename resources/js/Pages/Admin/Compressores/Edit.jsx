import Layout from "@/Layouts/Admin/Layout";

export default function ({dados}) {
    return (
        <Layout container titlePage="Compressores Cadastrados" menu="compressores" submenu="cadastrados">
            <div className="row justify-content">
                <div className="col-auto">
                    <button className="btn btn-primary">Cadastrar</button>
                </div>
            </div>
            <div className="">
                <table className="table">
                    <thead>
                    <tr>
                        <th className="col-1">Código</th>
                        <th>Identificação</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {dados.map((item) => {
                        return (
                            <tr>
                                <td>{item.id}</td>
                                <td>{item.nome}</td>
                                <td>
                                    <button className="btn btn-primary">Ver</button>
                                </td>
                            </tr>
                        )
                    })}
                    </tbody>
                </table>
            </div>
        </Layout>
    )
}
