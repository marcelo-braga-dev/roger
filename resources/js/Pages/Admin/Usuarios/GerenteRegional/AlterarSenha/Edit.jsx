import Layout from "@/Layouts/Admin/Layout";
import {TextField} from "@mui/material";
import {router, useForm} from "@inertiajs/react";
import {useState} from "react";
import DadosUsuario from "@/Components/Usuarios/DadosUsuario";

export default function ({id, dados}) {
    const [alerta, setAlerta] = useState(false)
    const {data, setData} = useForm({
        senha: '',
        confirmar: ''
    })

    function submit(e) {
        e.preventDefault()
        if (data.senha && data.senha === data.confirmar) {
            router.put(route('admin.usuarios.gerentes-senhas-update', id), {
                '_method': 'put',
                ...data
            })
            return
        }
        setAlerta(true)
    }

    return (
        <Layout container titlePage="Atualizar Senha" menu="usuarios" voltar={route('admin.usuarios.gerente-regional.show', id)}>
            <div className="mb-5">
                <DadosUsuario dados={dados}/>
            </div>

            {alerta && <div className="text-danger mb-3">Senha não coincidem.</div>}
            <form onSubmit={submit}>
                <div className="row">
                    <div className="col-md-4">
                        <TextField label="Senha" type="password" fullWidth
                                   onChange={e => setData('senha', e.target.value)}/>
                    </div>
                    <div className="col-md-4">
                        <TextField label="Repetir Senha" type="password" fullWidth
                                   onChange={e => setData('confirmar', e.target.value)}/>
                    </div>
                </div>
                <div className="row mt-3">
                    <div className="col">
                        <button className="btn btn-primary">Atualizar</button>
                    </div>
                </div>
            </form>
        </Layout>
    )
}
