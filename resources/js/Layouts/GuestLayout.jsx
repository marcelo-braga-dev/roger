export default function Guest({children}) {
    return (
        <div className="container-fluid">
            <div className="row justify-content-center vh-100">
                <div className="col-11 col-md-4 mt-8 text-white">
                    {children}
                </div>
            </div>
        </div>
    );
}
