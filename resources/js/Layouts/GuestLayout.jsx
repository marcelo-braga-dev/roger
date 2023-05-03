export default function Guest({children}) {
    return (
        <div className="container-fluid bg-dark">
            <div className="row justify-content-center vh-100">
                <div className="col-11 col-md-auto mt-8 text-white">
                    {children}
                </div>
            </div>
        </div>
    );
}
