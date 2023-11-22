/*
Template Name: Las Futbolistas - Admin
Author: Pablo
Website: https://admin.lasfutbolistas.com/
Contact: ppaabloms96@gmail.com
File: Role Init Js File
*/

//load list
loadTeamData(roleList);
var editlist = false;

//Detected button to change class view
var list = document.querySelectorAll(".team-list");
if (list) {
    var buttonGroups = document.querySelectorAll('.filter-button');
    if (buttonGroups) {
        Array.from(buttonGroups).forEach(function (btnGroup) {
            btnGroup.addEventListener('click', onButtonGroupClick);
        });
    }
}

// Reset Modal to new
Array.from(document.querySelectorAll(".addrole-modal")).forEach(function (elem) {
    elem.addEventListener('click', function (event) {
        document.getElementById("createRoleLabel").hidden = false;
        document.getElementById("editRoleLabel").hidden = true;

        document.getElementById("roleId").value = '';
        document.getElementById('roleName').value = '';

      document.getElementById("memberlist-form").classList.remove('was-validated');
    });
});

// Form Event
(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    event.preventDefault();
                    var inputName = document.getElementById('roleName').value;

                    if (inputName !== "" && !editlist) {
                        var newRoleId = findNextId();
                        var newRole = {
                            "id": newRoleId,
                            "name": inputName,
                            "guard_name": "web"
                        };
                        ajaxRole(newRole,'store')
                        roleList.push(newRole);
                        
                        sortElementsById();


                        
                    }else if(inputName !== "" && editlist){
                        var getEditid = 0;
                        getEditid = document.getElementById("roleId").value;
                        roleList = roleList.map(function (item) {
                            if (item.id == getEditid) {
                                var editObj = {
                                    'id': getEditid,
                                    'name': inputName,
                                }
                                ajaxRole(editObj,'update')
                                return editObj;
                            }
                            return item;
                        });
                        editlist = false;
                    }

                    loadTeamData(roleList)
                    document.getElementById("modalBtnClose").click();
                }
                form.classList.add('was-validated');
            }, false)
        })
})()


// Search product list
var searchRoleList = document.getElementById("searchRoleList");
searchRoleList.addEventListener("keyup", function () {
    var inputVal = searchRoleList.value.toLowerCase();
    function filterItems(arr, query) {
        return arr.filter(function (el) {
            return (el.name.toLowerCase().indexOf(query.toLowerCase()) !== -1)
        })
    }

    var filterData = filterItems(roleList, inputVal);
    if (filterData.length == 0) {
        document.getElementById("noresult").style.display = "block";
        document.getElementById("rolelist").style.display = "none";
    } else {
        document.getElementById("noresult").style.display = "none";
        document.getElementById("rolelist").style.display = "block";
    }

    loadTeamData(filterData);
});

//Change class to view
function onButtonGroupClick(event) {

    if (event.target.id === 'list-view-button' || event.target.parentElement.id === 'list-view-button') {
        document.getElementById("list-view-button").classList.add("active");
        document.getElementById("grid-view-button").classList.remove("active");
        Array.from(list).forEach(function (el) {
            el.classList.add("list-view-filter");
            el.classList.remove("grid-view-filter");
        });

    } else {
        document.getElementById("grid-view-button").classList.add("active");
        document.getElementById("list-view-button").classList.remove("active");
        Array.from(list).forEach(function (el) {
            el.classList.remove("list-view-filter");
            el.classList.add("grid-view-filter");
        });
    }
}

// Edit modal with data
function editMemberList() {
    var getEditid = 0;
    Array.from(document.querySelectorAll(".edit-list")).forEach(function (elem) {
        elem.addEventListener('click', function (event) {
            getEditid = elem.getAttribute('data-edit-id');
            roleList = roleList.map(function (item) {
                if (item.id == getEditid) {
                    editlist = true;
                    document.getElementById("createRoleLabel").hidden = true;
                    document.getElementById("editRoleLabel").hidden = false;

                    document.getElementById("roleId").value = item.id;
                    document.getElementById('roleName').value = item.name;
                    document.getElementById("memberlist-form").classList.remove('was-validated');
                }
                return item;
            });
        });
    });
};

function fetchIdFromObj(member) {
    return parseInt(member.id);
}

function findNextId() {
    if (roleList.length === 0) {
        return 0;
    }
    var lastElementId = fetchIdFromObj(roleList[roleList.length - 1]),
        firstElementId = fetchIdFromObj(roleList[0]);
    return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
}

function sortElementsById() {
    var manymember = roleList.sort(function (a, b) {
        var x = fetchIdFromObj(a);
        var y = fetchIdFromObj(b);

        return x - y;
    })
    console.log(manymember);
    loadTeamData(manymember);
}

//pirnt data
function loadTeamData(datas) {
    document.querySelector("#role-list").innerHTML = '';

    Array.from(datas).forEach(function (roleData, index) {
        document.querySelector("#role-list").innerHTML +=
        '<div class="col">\
            <div class="card team-box">\
                <div class="card-body p-2">\
                    <div class="row align-items-center role-row">\
                        <div class="col-lg-10 col-10">\
                            <div class="team-profile-img">\
                                <div class="text-muted text-center">'+roleData.id+'</div>\
                                <div class="team-content">\
                                    <a class="member-name">\
                                        <h5 class="fs-16 mb-1">'+roleData.name+'</h5>\
                                    </a>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="col-1">\
                            <div class="row">\
                                <div class="col text-end dropdown">\
                                    <a href="javascript:void(0);" data-toggle="dropdown" aria-expanded="false">\
                                        <i class="fa fa-bars"></i>\
                                    </a>\
                                    <ul class="dropdown-menu dropdown-menu-end">\
                                        <li><a class="dropdown-item edit-list" href="#addroleModal"  data-toggle="modal" data-edit-id="'+roleData.id+'"><i class="ri-pencil-line me-2 align-bottom text-muted"></i>Edit</a></li>\
                                        <li><a class="dropdown-item edit-list" href="roles/'+roleData.id+'/edit"><i class="ri-apps-2-line me-2 align-bottom text-muted"></i>Panel</a></li>\
                                        <li><a class="dropdown-item remove-list" href="#removeRoleModal" data-toggle="modal" data-remove-id="'+roleData.id+'"><i class="ri-delete-bin-5-line me-2 align-bottom text-muted"></i>Remove</a></li>\
                                    </ul>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="col-1"></div>\
                    </div>\
                </div>\
            </div>\
        </div>';
        editMemberList();
        removeItem();
    });

}

function removeItem() {
    var getid = 0;
    Array.from(document.querySelectorAll(".remove-list")).forEach(function (item) {
        item.addEventListener('click', function (event) {
            getid = item.getAttribute('data-remove-id');
            document.getElementById("remove-item").addEventListener("click", function () {
                function arrayRemove(arr, value) {
                    return arr.filter(function (ele) {
                        return ele.id != value;
                    });
                }
                ajaxRole({'id':getid}, 'destroy');
                var filtered = arrayRemove(roleList, getid);

                roleList = filtered;

                loadTeamData(roleList);
                document.getElementById("close-roleItem").click();
            });
        });
    });
}

function ajaxRole (params, route) {

    var types = {'store': 'POST', 'update': 'PUT', 'destroy': 'DELETE'};
    var urls = {
        'store': 'roles', 
        'update': 'roles/' + params.id , 
        'destroy': 'roles/' + params.id
    };
    
    $.ajax({
        type: types[route],
        url: urls[route],
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:params,
        success:function(data){
            if ( data === '') {
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
                    title: 'Correcto'
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
                    title: 'Error'
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