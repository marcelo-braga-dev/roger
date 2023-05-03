import Layout from "@/Layouts/Admin/Layout";
import convertFloatToMoney from "@/utils/convertFloatToMoney";

export default function ({usuarios}) {
    return (
        <Layout container titlePage="Vendedores" menu="usuarios" submenu="vendedores">
            <div className="row justify-content-between">
                <div className="col-auto">
                    <a className="btn btn-primary btn-sm" href={route('admin.usuarios.vendedores.create')}>
                        Cadastrar Vendedor
                    </a>
                </div>
            </div>
            <div className="table-responsive">
                <table className="table table-sm table-striped text-sm">
                    <thead>
                    <tr>
                        <th className="col-1">Cód.</th>
                        <th>Nome</th>
                        <th>Gerente</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {usuarios.map((usuario, index) => {
                        return (
                            <tr key={index}>
                                <td className="text-center">{usuario.codigo}</td>
                                <td className="text-wrap"><b>{usuario.nome}</b></td>
                                <td className="text-wrap">{usuario.superior_nome}</td>
                                <td>
                                    <a className="btn btn-primary btn-sm p-1 px-3 m-0"
                                    href={route('admin.usuarios.vendedores.show', usuario.id)}>Ver</a>
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
