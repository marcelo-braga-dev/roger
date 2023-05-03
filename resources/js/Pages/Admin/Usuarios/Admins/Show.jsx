import Layout from "@/Layouts/Admin/Layout";
import DadosUsuario from "@/Components/Usuarios/DadosUsuario";

export default function ({dados}) {
    return (
        <Layout container titlePage="Informações do Admin" voltar={route('admin.usuarios.admins.index')}
                menu="usuarios" submenu="admins">
            <div className="row justify-content-between">
                <div className="col-auto">
                    <DadosUsuario dados={dados}/>
                </div>
                <div className="col-auto">
                    <a className="btn btn-primary btn-sm mx-2 mb-3"
                       href={route('admin.usuarios.admins.edit', dados.id)}>Editar</a>
                    <a className="btn btn-primary btn-sm mx-2 mb-3"
                       href={route('admin.usuarios.admins-senhas', dados.id)}>Atualizar Senha</a>
                </div>
            </div>
        </Layout>
    )
}
