function Storage(dataName) {
    // this.nombreBasicoParaAlmacenado = "data";
    this.nombreBasicoParaAlmacenado = dataName;
    //BASICOS
    this.cargarX = function(nombre) {return localStorage.getItem(nombre); }
    this.guardarX = function(nombre,valor) {localStorage.setItem(nombre, valor); }
    this.eliminarX = function(nombre) {localStorage.removeItem(nombre); }


    //CON ESTRUCTURA

    //unico obligatorio es id
    this.getNombre = function (objeto){
        if(!objeto.id){
            objeto.id = this.getNewId();
        }
        return this.nombreBasicoParaAlmacenado + objeto.id;
    }

    this.recuperarIdSegunNombre = function(nombreEnStorageConId) {
        return nombreEnStorageConId.replace(this.nombreBasicoParaAlmacenado,"");
    }

    this.agregar = function(objeto) {
        var objetoGuardar = JSON.stringify(objeto);
        this.guardarX(this.getNombre(objeto),objetoGuardar);
    }

    this.getNewId = function(){
        return this.cargarGuardados().length + 1;
    }

    this.editar = function(objeto) {
        var objetoGuardar = JSON.stringify(objeto);
        this.guardarX(this.getNombre(objeto),objetoGuardar);
    }


    this.eliminar = function(objeto) {
        this.eliminarX(this.getNombre(objeto));
    }


    this.cargar = function(objeto) {
        return JSON.parse(this.cargarX(this.getNombre(objeto)));
    }




    //generales
    this.verTodos = function () {
        for(var i in localStorage) {
            alert(('Log storage:' + i + ' = ' + localStorage[i]));
        }
    }

    //por grado de peligrosidad, se evito el eliminado sin estar seguro
    this.eliminarTodos = function() {
    }

    this.eliminarTodosEstoySeguro = function() {
        // for(var i in localStorage) {
        //    this.eliminarX(i); 
        //    alert(("Log storage: Eliminando.." + i));
        // }
    }

    this.cargarGuardados = function() {
        // verTodosStorages();
        var indice;
        var datos = [];
        for(var i in localStorage) {
            if(i.indexOf(this.nombreBasicoParaAlmacenado)>-1){
                indice = i.replace(this.nombreBasicoParaAlmacenado,"");
                var storageName = this.nombreBasicoParaAlmacenado + indice;
                // console.log("storageName = "); console.log(storageName);
                
                var objetoCargado = JSON.parse(this.cargarX(storageName));
                objetoCargado.storageName = storageName;
                datos.push(objetoCargado);
            }
        }
        return datos;
    }

    this.eliminarTodosLosGuardados = function() {
        // verTodosStorages();
        var indice;
        var datos = [];
        for(var i in localStorage) {
            if(i.indexOf(this.nombreBasicoParaAlmacenado)>-1){
                indice = i.replace(this.nombreBasicoParaAlmacenado,"");
                this.eliminarX(this.nombreBasicoParaAlmacenado + indice);
            }
        }
        return datos;
    }



    this.calcularEspacios = function () {
        var limiteStorage = 5240370;
        var resul = {},total,mayor = 0,mayorId,indice,actual,nombreEnStorage;
        nombreEnStorage = this.nombreBasicoParaAlmacenado;
        total = 0;
        for(var i in localStorage) {
            //if(this.debug)console.log(i + ' = ' + localStorage[i]);
            actual = localStorage[i].length;
            if(mayor<actual) {
                mayor = actual;
                indice = -1;

                if(i.indexOf(nombreEnStorage)>-1){indice = i.replace(nombreEnStorage,"");}
                mayorId = indice;
            }
            total = parseInt(total) + parseInt(actual);
        }

        resul = {
            limiteStorage:limiteStorage,
            total:total,
            mayorId:mayorId,
            mayor:mayor
        };
        return resul;
    }


}


class StorageUnico{
    constructor(uniqueName){
        this.sesionObj = new Storage(uniqueName);
        this.cargar();
    }

    cargar(){
        var todos = this.sesionObj.cargarGuardados();
        this.sesion = null;
        if(todos.length>0){
            this.sesion = todos[0];
        }
        return this.sesion;
    }

    get(property){
        if(!this.sesion) return null;

        if(typeof(this.sesion[property]) != "undefined"){
            return this.sesion[property];
        }else{
            return null;
        }
    }

    set(property,value){
        if(!this.sesion){
            this.sesion = {};
            this.sesion[property] = value;
            this.sesion.id = 1;
        }else{
            this.sesion[property] = value;
        }
        
        this.sesionObj.agregar(this.sesion);
        this.cargar();
    }

    remove(property){
        if(!this.sesion) return null;

        if(typeof(this.sesion[property]) != "undefined"){
            delete this.sesion[property];
            this.sesionObj.agregar(this.sesion);
        }
    }
}
