$('#itemForm').on('submit', function (e) {
    e.preventDefault();

    const loadingOverlay = $('#loadingOverlay');
    const errorContainer = $('.alert-danger ul'); // エラー表示部分を指定

    // ローディング表示＆エラー初期化
    loadingOverlay.show();
    errorContainer.empty();

    // フォームデータ送信
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
            window.location.href = redirectUrl; // 正常時リダイレクト
        },
        error: function (xhr) {
            if (xhr.status === 422) {
               
                // バリデーションエラーの処理
                const errors = xhr.responseJSON.errors;
                for (const field in errors) { 
                    errors[field].forEach(message => {
                        errorContainer.append(`<li>${message}</li>`);
                    });
                    console.log(errors[field]);
                }
                $('.alert-danger').show();
            } else {
                console.error('予期せぬエラーが発生しました。');
            }
        },
        complete: function () {
            loadingOverlay.hide(); // ローディング非表示
        }
    });
});
