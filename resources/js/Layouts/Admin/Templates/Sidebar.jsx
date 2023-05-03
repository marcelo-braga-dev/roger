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
                {'menu': 'Geral', 'url': route('home'), 'tagSubmenu': 'geral'},
                {
                    'menu': 'Meta dos Vendedores',
                    'url': route('home'),
                    'tagSubmenu': 'vendedores'
                },
            ]
        },
    ];

    return (<>
            <aside id="sidenav-main" style={{zIndex: 100}}
                   className="sidenav navbar navbar-vertical navbar-expand-xs fixed-start  bg-primary">
                <div>
                    <a href="/">
                        <div className="text-center py-3 bg-white">
                            <img src="/storage/crm/imagens/logo.png" className="" width="200" alt="logo"/>
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
