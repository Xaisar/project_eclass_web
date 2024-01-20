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
        name: 'picture',
        data: 'picture',
        width: '6%',
        mRender: function (data, type, row) {
            return ` <img src="${$('meta[name="base-url"]').attr('content')}/assets/images/students/${data}" alt="" class="avatar-md rounded-circle me-2">`;
        }
    },
    {
        name: 'identity_number',
        data: 'identity_number',
    },
    {
        name: 'name',
        data: 'name',
    },
    {
        name: 'gender',
        data: 'gender',
    },
    {
        name: 'birthday',
        data: 'birthday',
    },
    {
        name: 'class_group',
        data: 'class_group',
    },
    {
        name: 'status',
        data: 'status',
        mRender: function (data, type, row) {
            return `<div class="badge badge-soft-${data == true ? 'success' : 'danger'} font-size-12">${data == true ? 'Aktif' : 'Tidak Aktif'}</div>`;
        }
    },
]);
