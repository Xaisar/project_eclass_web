initDataTable('#dataTable', [{
        name: 'hashid',
        data: 'hashid',
        sortable: false,
        searchable: false,
        width: '4%',
        mRender: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    },
    {
        name: 'name',
        data: 'name',
    }, {
        name: 'guard_name',
        data: 'guard_name'
    }, {
        name: 'hashid',
        data: 'hashid',
        width: '4%',
        mRender: function (data) {
            var render = ``;
            if (userPermissions.includes('change-permissions')) {
                render += ` <button class="btn btn-sm btn-primary waves-effect edit waves-light" data-toggle="ajax" data-target="${window.location.href}/${data}/change-permission"><i class=" bx bx-check-shield"></i></button>`
            }
            return render
        }
    },
]);
$("#uid").click(function () {
    if (this.checked == true) {
        $(".uid").prop("checked", true);
    } else {
        $(".uid").prop("checked", false);
    }
});
