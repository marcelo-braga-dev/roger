import Layout from "@/Layouts/Admin/Layout";
import DadosUsuario from "@/Components/Usuarios/DadosUsuario";

export default function ({dados}) {
    return (
        <Layout container titlePage="Informações do Vendedor" voltar={route('admin.usuarios.vendedores.index')}
                menu="usuarios" submenu="vendedores">

            <div className="row justify-content-between">
                <div className="col-auto">
                    <DadosUsuario dados={dados}/>
                </div>
                <div className="col-auto">
                    <a className="btn btn-primary btn-sm mx-2 mb-3"
                       href={route('admin.usuarios.vendedores.edit', dados.id)}>Editar</a>
                    <a className="btn btn-primary btn-sm mx-2 mb-3"
                       href={route('admin.usuarios.vendedores-senhas', dados.id)}>Atualizar Senha</a>
                </div>
            </div>


        </Layout>
    )
}
