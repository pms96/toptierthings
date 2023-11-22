/*
Template Name: Las Futbolistas - Admin
Author: Pablo
Website: https://admin.lasfutbolistas.com/
Contact: ppaabloms96@gmail.com
File: Permissions Init Js File
*/



function ajaxAsingPermission (params, route) {

    var routes = {
        'givePermission':'/admin/roles/' + params.role_id + '/permissions' ,
        'revokePermission': '/admin/roles/' + params.role_id + '/permissions/' + params.permission_id,
    };

    $.ajax({
        type: 'POST',
        url: routes[route],
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:params,
        success:function(data){
            
            if ( data === 'Permiso Añadido' || data === 'Permiso Eliminado') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'success',
                    title: data
                })
            }else{
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                
                Toast.fire({
                    icon: 'error',
                    title: data
                })
            }
        },
        error:function(){

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            
            Toast.fire({
                icon: 'error',
                title: 'Error'
            })

        }
     });
}

function permissionRole (bool, permission, role, module) {

    var count = document.getElementById('coutnModule_' + module).innerHTML;
    document.getElementById('coutnModule_' + module).innerHTML = '';
    document.getElementById('coutnModule_' + module).innerHTML = bool ? parseInt(count) + 1 : parseInt(count) - 1;
    var permissionName = document.getElementById('permission_' + permission).value;

    var params = {
        permission_name: permissionName,
        permission_id: permission,
        role_id: role,
    };

    var routes = bool ? 'givePermission' : 'revokePermission';

    ajaxAsingPermission(params, routes);
}