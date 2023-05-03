import {useEffect} from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import {Head, Link, useForm} from '@inertiajs/react';
import {TextField} from "@mui/material";

export default function Login({status, canResetPassword}) {

    const {data, setData, post, processing, errors, reset} = useForm({
        email: '',
        password: '',
        remember: '',
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const onHandleChange = (event) => {
        setData(event.target.name, event.target.type === 'checkbox' ? event.target.checked : event.target.value);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route('login'));
    };

    return (
        <GuestLayout>
            <Head title="Log in"/>

            {status && <div className="mb-4 font-medium text-sm text-green-600">{status}</div>}
            <div className="shadow bg-white p-4 rounded">
                <form onSubmit={submit}>
                    <div className="row mb-4 w-100">
                        <div className="col-auto text-center">
                            <img src="/storage/crm/imagens/logo.png" className="w-60" alt="logo"/>
                        </div>
                    </div>
                    <div>
                        <TextField
                            size="small"
                            id="email"
                            type="email"
                            name="email"
                            label="E-mail"
                            value={data.email}
                            className="block w-full"
                            isFocused={true}
                            onChange={onHandleChange}
                            fullWidth
                        />
                        {errors.email && <small className="text-danger">{errors.email}</small>}
                    </div>

                    <div className="mt-4">
                        <TextField
                            fullWidth
                            id="password"
                            label="Senha"
                            size="small"
                            type="password"
                            name="password"
                            value={data.password}
                            className="block w-full"
                            onChange={onHandleChange}
                        />
                        {errors.password && <small className="text-danger">{errors.password}</small>}
                    </div>

                    <div className="block mt-2">
                        <label className="flex items-center">
                            <Checkbox name="remember" value={data.remember} handleChange={onHandleChange}/>
                            <span className="ms-2 text-sm">Lembrar senha</span>
                        </label>
                    </div>

                    <div className="flex items-center text-center justify-end mt-3">
                        {!canResetPassword && (
                            <Link href={route('password.request')}  className="">
                                Forgot your password?
                            </Link>
                        )}

                        <button type="submit" className="btn btn-primary ml-4">
                            Entrar
                        </button>
                    </div>
                </form>
            </div>

        </GuestLayout>
    );
}
