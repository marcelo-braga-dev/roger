import Layout from "@/Layouts/Admin/Layout";
import {TextField} from "@mui/material";
import {useForm} from "@inertiajs/react";

export default function () {
    const {post, setData} = useForm()
    function submit(e) {
        e.preventDefault()
        post(route('admin.compressores.store'))
    }

    return (
        <Layout container titlePage="Compressores" menu="compressores" submenu="novo">
            <h6>Cadastrar Compressor</h6>
            <form onSubmit={submit}>
                <div className="row mt-4">
                    <div className="col-md-6 mb-4">
                        <TextField label="Identificação" fullWidth required
                        onChange={e => setData('nome', e.target.value)}/>
                    </div>
                </div>
                <div className="row">
                    <div className="col">
                        <button className="btn btn-primary">Cadastrar</button>
                    </div>
                </div>
            </form>
        </Layout>
    )
}
