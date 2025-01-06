$('#itemForm').on('submit', function (e) {
    e.preventDefault();

    const loadingOverlay = $('#loadingOverlay');

    // ローディング表示
    loadingOverlay.show();

    // Ajaxリクエストの例
    const formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function () {
            console.log('送信が完了しました！');
            window.location.href = redirectUrl;
        },
        error: function () {
            console.log('送信に失敗しました。');
        },
        complete: function () {
            // ローディング非表示
            loadingOverlay.hide();
        }
    });
});
