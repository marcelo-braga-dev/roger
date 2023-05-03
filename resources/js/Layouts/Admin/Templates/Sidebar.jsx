import * as React from "react";

export default function Sidebar({menuSidebar, submenuSidebar}) {
    const logo = "/storage/crm/imagens/logo.png";

    const pages = [
        {
            'menu': 'Dashboard',
            'icone': 'fas fa-chart-line',
            'tagMenu': 'dashboard',
            'url': route('home'),
            'submenu': [
            ]
        },
        {
            'menu': 'Gestão de Metas',
            'icone': 'fas fa-bullseye',
            'tagMenu': 'gestao_metas',
            'submenu': [
                {'menu': 'Geral', 'url': route('admin.gestao-metas.geral.index'), 'tagSubmenu': 'geral'},
                {
                    'menu': 'Meta dos Vendedores',
                    'url': route('admin.gestao-metas.vendedores.index'),
                    'tagSubmenu': 'vendedores'
                }, {
                    'menu': 'Meta dos Gerentes',
                    'url': route('admin.gestao-metas.gerentes.index'),
                    'tagSubmenu': 'gerentes'
                },
            ]
        },
        {
            'menu': 'Faturamento',
            'icone': 'fas fa-dollar-sign',
            'tagMenu': 'faturamento',
            'submenu': [
                {'menu': 'Vendedores', 'url': route('admin.faturamento.vendedores.index'), 'tagSubmenu': 'vendedores'},
                {'menu': 'Produtos', 'url': route('admin.faturamento.produtos.index'), 'tagSubmenu': 'produtos'},
                // {'menu': 'Clientes', 'url': route('admin.faturamento.clientes.index'), 'tagSubmenu': 'clientes'},
            ]
        },
        {
            'menu': 'Simuladores',
            'icone': 'fas fa-truck',
            'tagMenu': 'simuladores',
            'submenu': [
                {'menu': 'Simulador CIF', 'url': route('admin.simuladores.cif.index'), 'tagSubmenu': 'cif'},
                {'menu': 'Simulador FOB', 'url': route('admin.simuladores.fob.index'), 'tagSubmenu': 'fob'},
                {'menu': 'Cadastros', 'url': route('admin.simuladores.cadastros.index'), 'tagSubmenu': 'cadastros'},
                {'menu': 'Clientes', 'url': route('admin.simuladores.clientes.index'), 'tagSubmenu': 'clientes'},
                {'menu': 'Produtos', 'url': route('admin.simuladores.produtos.index'), 'tagSubmenu': 'produtos'},
            ]
        },
        {
            'menu': 'Análises',
            'icone': 'fas fa-chart-pie',
            'tagMenu': 'analises',
            'submenu': [
                {'menu': 'Prazo Médio', 'url': route('admin.analise.prazo-medio.index'), 'tagSubmenu': 'prazo_medio'},
                {'menu': 'M.C.', 'url': route('admin.analise.mc.index'), 'tagSubmenu': 'mc'},
                {
                    'menu': 'Desconto Médio',
                    'url': route('admin.analise.desconto-medio.index'),
                    'tagSubmenu': 'desconto_medio'
                },
            ]
        },
        {
            'menu': 'Relatórios',
            'icone': 'fas fa-file',
            'tagMenu': 'relatorios',
            'submenu': [
                {
                    'menu': 'Importar Arquivo',
                    'url': route('admin.importacao.importar.index'),
                    'tagSubmenu': 'importar'
                },{
                    'menu': 'Histórico de Importação',
                    'url': route('admin.importacao.historico.index'),
                    'tagSubmenu': 'historico'
                },
            ]
        },
        {
            'menu': 'Usuários',
            'icone': 'fas fa-users',
            'tagMenu': 'usuarios',
            'submenu': [
                {'menu': 'Vendedores', 'url': route('admin.usuarios.vendedores.index'), 'tagSubmenu': 'vendedores'},
                {
                    'menu': 'Gerentes Regional',
                    'url': route('admin.usuarios.gerente-regional.index'),
                    'tagSubmenu': 'gerente_regional'
                },
                {'menu': 'Admins', 'url': route('admin.usuarios.admins.index'), 'tagSubmenu': 'admins'},
            ]
        },
    ];

    return (<>
            <aside id="sidenav-main" style={{zIndex: 100}}
                   className="sidenav navbar navbar-vertical navbar-expand-xs fixed-start  bg-primary">
                <div>
                    <a href="/">
                        <div className="text-center py-3 bg-white">
                            <img src="/storage/crm/imagens/logo.png" className="" width="200" alt="main_logo"/>
                        </div>
                    </a>
                </div>
                <div className="horizontal px-1 mt-3">
                    <div className="row justify-content-end pe-3 d-md-none">
                        <div className="col-auto">
                            <button id="iconSidenav" className="btn btn-link text-danger p-0 m-0">
                                <i className="fas fa-times"/>
                            </button>
                        </div>
                    </div>
                    <div className="accordion accordion-flush w-auto mb-6" id="accordionFlushSidebar">
                        {/*ITEMS*/}
                        {pages.map(({menu, icone, submenu, tagMenu, url}, index) => (
                            <div key={index} className="accordion-item text-dark navbar-nav py-1">
                                <div className="accordion-header nav-item" id={"flush-heading-" + index}>
                                    <a href={url ?? null}>
                                        <div
                                            className={(tagMenu === menuSidebar ? '' : 'collapsed ') + "accordion-button nav-link p-1 m-0"}
                                            data-bs-toggle="collapse" aria-controls={"flush-collapse-" + index}
                                            data-bs-target={"#flush-collapse-" + index} aria-expanded="false">
                                            <div className="icon icon-sm border-radius-md d-flex align-items-center">
                                                <i className={icone + " text-sm opacity-10"} style={ tagMenu === menuSidebar ?{color: 'orange'}:{color: 'white'}}></i>
                                            </div>
                                            <span className="ms-2 font-weight-bold"
                                                  style={ tagMenu === menuSidebar ?{color: 'orange'}:{color: 'white'}}>{menu}</span>
                                        </div>
                                    </a>
                                </div>

                                <div id={"flush-collapse-" + index}
                                     className={(tagMenu === menuSidebar ? 'show ' : '') + "accordion-collapse nav-item collapse"}
                                     aria-labelledby={"flush-heading-" + index}
                                     data-bs-parent="#accordionFlushSidebar">

                                    {submenu.map(({menu, url, tagSubmenu}, i) => (
                                        <a href={url} key={i} className="text-sm text-white-50">
                                            <div className="accordion-body p-0 ms-5 mb-2">
                                                <span className="nav-link-text"
                                                      style={tagSubmenu + tagMenu === submenuSidebar + menuSidebar ? {color: 'orange'} : {}}>
                                                    {menu}
                                                </span>
                                            </div>
                                        </a>
                                    ))}
                                </div>
                            </div>
                        ))}
                        {/*ITEMS - FIM*/}
                    </div>
                </div>
            </aside>
        </>
    )
}
