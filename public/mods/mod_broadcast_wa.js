if (typeof table == "undefined") {
    let table = null;
}

table = initDataTable(
    "#dataTable",
    [
        {
            name: "id",
            data: "id",
            sortable: false,
            searchable: false,
            width: "4%",
            mRender: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
        },
        {
            name: "date",
            data: "date",
        },
        {
            name: "message",
            data: "message",
        },
    ],
    function () {
        if ($(".edit-btn").length > 0) {
            $(".edit-btn").on("click", editBtnAction);
        }
    }
);
