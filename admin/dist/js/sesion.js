
var sesion;
function verificarSesion(s)
{
    sesion = s;
    if(SesionVencida())
    {
        location.href = '/admin/login.html';
    }
  
}

function usuarioLogeado() {
    return sesion.get('token') != null;
}

function SesionVencida() {
    var vencido = true;

    if (sesion.get('usuario') != null) {
        var token = sesion.get('usuario');
        var json = parseJwt(token);

        vencido = moment().unix() > json.vencimiento;
    }

    return vencido;
}


function parseJwt(token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function (c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
};
