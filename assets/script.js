; //esto es para poder cerra si hay codigos de otras fuentas para que no haya conflicto


//si no trabajamos con modules ECMASCRIPT6 entonses utilizamos el metodo de la funciones anonimas
//auto ejecutables (IFFE) que permiten mantener un scope y controlar el scope de tu programacion
//interna
(function(d,w,c,m){
   M.AutoInit();
   M.Datepicker.init(d.querySelector(".datepicker"),{
      autoClose:true,
      format:"yyyy-mm-dd" //le ponemos este formato por que es que maneja la base de datos mysql
   })

   const horario = d.getElementById("horario"),
         form = d.forms[0],
         respuesta = d.querySelector(".Response")
   
   // mandamos mensajes de error y ok

   const mensaje_error = msg => `
      <p class="section center red darken-1 white-text Messages">
         ${msg}
         <br>
         <i class="material-icons">sentiment_very_dissatisfied</i>
      </p>
   `;

   const mensaje_ok = msg => `
      <p class="section center green darken-1 white-text Messages">
         ${msg}
         <br>
         <i class="material-icons">sentiment_very_satisfied</i>
      </p>
   `;

   // delegacion de eventos. delegamos el evento aun elemento superior y ya despues bamos hacer la programcion para ver quien desencadeno el evento
   d.addEventListener('change' , e =>{
      if(e.target.matches("#actividad")){

         let data = new FormData()
         data.append('disciplina',e.target.value)

         fetch('./app.php',{
            body:data,
            method:'post'
         })
         .then(res => {
            // c(res)
            return (res.ok) 
                  ? res.text() 
                  : Promise.reject({status:res.status, statusText:res.statusText})
         })
         .then(res =>{
            // c(res)
            horario.innerHTML=""
            horario.insertAdjacentHTML('beforeend',`<h5 class="grey-text text-darken-2">ELIGE UN HORARIO</h5> ${res}`)
         })
         .catch(err =>{
            let mensaje = mensaje_error(`Parece que hay un problema. Error ${err.status}: ${err.statusText}`)
            // c(mensaje)
            horario.innerHTML=""
            horario.insertAdjacentHTML('beforeend', mensaje)

         })
      }   
   })   

   d.addEventListener('submit' , e =>{
      if(e.target.matches('form')){
         e.preventDefault()

         let data = new FormData(e.target)

         fetch('./app.php', {
            body: data,
            method: 'post'
         })
         .then(res => {
            // c(res)
            return (res.ok)
               ? res.json()
               : Promise.reject({ status: res.status, statusText: res.statusText })
         })
         .then(res => {
            // c(res)
            let mensaje = ""
            if(res.err){
               mensaje = mensaje_error(res.msg)
            }else{
               mensaje = mensaje_ok(res.msg)
               form.reset()
            }

            respuesta.innerHTML = mensaje;
            
         })
         .catch(err => {
            console.log(err);
            let mensaje = mensaje_error(`Parece que hay un problema. Error ${err}`)
            // c(mensaje)
            respuesta.innerHTML = ""
            respuesta.insertAdjacentHTML('beforeend', mensaje)

         })
      }
   })

   d.addEventListener('click' , e =>{
      if(e.target.matches('.delete')){
         let seElimina = confirm(`Estas seguro de eleminar el registro del correo ${e.target.dataset.registro}`)
         if(seElimina){
            let data = new FormData()
            data.append("elimina_registro", e.target.dataset.registro)
   
            fetch('./app.php', {
               body: data,
               method: 'post'
            })
            .then(res =>{
               return (res.ok)
               ? w.location.reload()
               : Promise.reject( {status:res.status, statusText:res.statusText} ) 
            })
            .catch(err =>{
               let mensaje = `Parece que hay un problema. Error ${err.status}: ${err.statusText}`
               c(mensaje);
            })

         }else{
            return false;
         }
      }
   })   




})(document,window,console.log,M) //pasamos parametros generales y el objeto de Materialize