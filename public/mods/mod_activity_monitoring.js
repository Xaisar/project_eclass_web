initDataTable('#dataTable', [{
        name: 'hashid',
        data: 'hashid',
        width: "1%",
        sClass: "text-center",
        mRender: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        },
    },
    {
        name: 'name',
        data: 'name',
        mRender: function (data, type, row) {
            return ` <div class="row">
                            <div class="col-md-1">
                                <img src="${$('meta[name="base-url"]').attr('content')}/assets/images/students/${row.picture}" alt="" class="avatar-sm rounded-circle me-2">
                            </div>
                            <div class="col-md-10">
                                <strong>${row.name}</strong><br>
                                <span class="small">${row.identity_number}</span>
                            </div>
                        </div>`
        }
    },
    {
        name: 'gender',
        data: 'gender',
    },
    {
        name: 'online',
        data: 'online',
        mRender: function (data, type, row) {
            return `<div class="badge badge-soft-${data == true ? 'success' : 'danger'} font-size-12">${data == true ? 'Sedang Online' : 'Offline'}</div>`;
        }
    },
    {
        name: 'description',
        data: 'description',
    },
]);
