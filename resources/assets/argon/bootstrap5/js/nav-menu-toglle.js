export default function NavMenuToglle() {

    // Toggle Sidenav
    const iconNavbarSidenav = document.getElementById('iconNavbarSidenav');
    const iconSidenav = document.getElementById('iconSidenav');
    let body = document.getElementsByTagName('body')[0];
    let className = 'g-sidenav-pinned';

    if (iconNavbarSidenav) {
        iconNavbarSidenav.addEventListener("click", toggleSidenav);
    }

    if (iconSidenav) {
        iconSidenav.addEventListener("click", toggleSidenav);
    }

    function toggleSidenav() {
        if (body.classList.contains(className)) {
            body.classList.remove(className);

        } else {
            body.classList.add(className);
        }
    }
}
