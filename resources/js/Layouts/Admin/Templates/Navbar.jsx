import React, {useEffect} from "react";
import IconButton from "@mui/material/IconButton";
import Menu from "@mui/material/Menu";
import Typography from "@mui/material/Typography";
import MenuItem from "@mui/material/MenuItem";
import Box from "@mui/material/Box";
import {useForm} from "@inertiajs/react";
import ManageAccountsIcon from '@mui/icons-material/ManageAccounts';

import NavMenuToglle from "../../../../assets/argon/bootstrap5/js/nav-menu-toglle";

export default function Navbar({titlePage}) {
    // MENU PERFIL
    const settings = [];
    useEffect(() => {
        NavMenuToglle();
    }, []);

    const [anchorElUser, setAnchorElUser] = React.useState(null);

    const handleOpenUserMenu = (event) => {
        setAnchorElUser(event.currentTarget);
    };

    const handleCloseUserMenu = () => {
        setAnchorElUser(null);
    };

    const {post} = useForm();

    function submit() {
        post(route('logout'));
    }

    // MENU PERFIL - FIM

    return (<>
            <nav className="navbar navbar-main navbar-expand-lg pb-3 bg-primary" id="navbarBlur"
                 data-scroll="false" style={{"backgroundColor": "#252525"}}>
                <div className="container-fluid py-1 mt-2">
                    <nav aria-label="breadcrumb">
                        <h6 className="font-weight-bolder text-white mb-0 d-none d-md-block">{titlePage}</h6>
                    </nav>
                    <div className="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                        <div className="row justify-content-between w-100 d-flex">
                            <div className="col-auto">
                                <div className="nav-link text-white d-md-none" id="iconNavbarSidenav">
                                    <div className="sidenav-toggler-inner">
                                        <i className="sidenav-toggler-line bg-white"></i>
                                        <i className="sidenav-toggler-line bg-white"></i>
                                        <i className="sidenav-toggler-line bg-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div className="col-auto p-0 m-0">
                                <Box sx={{flexGrow: 0}} className="p-0 m-0">
                                    <IconButton onClick={handleOpenUserMenu} className="p-0 m-0" sx={{p: 0}}>
                                        <ManageAccountsIcon className=" text-white"/>
                                    </IconButton>
                                    <Menu
                                        sx={{mt: '25px'}}
                                        id="menu-appbar"
                                        anchorEl={anchorElUser}
                                        anchorOrigin={{
                                            vertical: 'top',
                                            horizontal: 'right',
                                        }}
                                        keepMounted
                                        transformOrigin={{
                                            vertical: 'top',
                                            horizontal: 'right',
                                        }}
                                        open={Boolean(anchorElUser)}
                                        onClose={handleCloseUserMenu}>
                                        {settings.map(({title, url}, i) => (
                                            <Typography key={i} color={"black"} variant={"inherit"} component={"a"}
                                                        href={url}>
                                                <MenuItem key={i} onClick={handleCloseUserMenu}>
                                                    {title}
                                                </MenuItem>
                                            </Typography>
                                        ))}
                                        <div onClick={() => submit()} style={{minWidth: 150}}>
                                            <MenuItem key="Sair" onClick={handleCloseUserMenu}>
                                                Sair
                                            </MenuItem>
                                        </div>
                                    </Menu>
                                </Box>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </>
    )
}
