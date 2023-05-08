import Layout from "@/Layouts/Admin/Layout";

export default function ({dados}) {
    return (
        <Layout container titlePage="Compressores Cadastrados" menu="compressores" submenu="cadastrados">
            <div className="row justify-content">
                <div className="col-auto">
                    <a href={route('admin.compressores.create')} className="btn btn-primary">Cadastrar</a>
                </div>
            </div>
            <div className="">
                <table className="table">
                    <thead>
                    <tr>
                        <th className="col-1 text-center">Código</th>
                        <th>Identificação</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {dados.map((item) => {
                        return (
                            <tr>
                                <td className="text-center">{item.id}</td>
                                <td>{item.nome}</td>
                                <td>
                                    <a href={route('admin.compressores.show', item.id)} className="btn btn-primary">Ver</a>
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
