import {Head} from '@inertiajs/react';

import ModalsAllerts from "@/Components/Modals/AlertsModals";
import Sidebar from "./Templates/Sidebar";
import Navbar from "./Templates/Navbar";

export default function Layout({children, titlePage, container, voltar, menu, submenu, errors = []}) {

    return (
        <>
            <Head><title>{titlePage}</title></Head>
            <ModalsAllerts/>
            <Sidebar menuSidebar={menu} submenuSidebar={submenu}/>

            <main className="main-content">
                <Navbar titlePage={titlePage}/>
                <div className="container">
                    {container ?
                        voltar ?
                            <div className="row">
                                <div className="col-12 bg-white px-lg-4 pt-2 pb-4 mb-4 mt-4 rounded">
                                    <div className="row justify-content-between border-bottom mb-3 p-2">
                                        <div className="col">
                                            <h5>{titlePage}</h5>
                                        </div>
                                        <div className="col-auto">
                                            <a className="btn btn-link text-dark btn-sm m-0 p-0" href={voltar}>
                                                <i className="fas fa-arrow-left"></i> Voltar
                                            </a>
                                        </div>
                                    </div>
                                    {errors[0] && <div className="alert alert-danger text-white">{errors[0]}</div>}
                                    {children}
                                </div>
                            </div> :
                            <div className="row">
                                <div className="col-12 bg-white p-3 mt-3 rounded pb-6 mb-6">
                                    {children}
                                </div>
                            </div>
                        : <div className="row">
                            {children}
                        </div>
                    }
                </div>
            </main>
        </>
    );
}
