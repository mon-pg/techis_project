<form action="#" method="GET">
            @csrf
        <div class="d-inline-flex mb-3">
            <div class="d-flex flex-column">
                <input class="form-control" type="search" name="query" placeholder="フリーワード検索"
                    value="{{ request('query') }}">

                <div class="search-content d-flex">
                    <p class="mini-title">絞り込み：</p>
                    <div class="form-floating">
                        <select class="form-select" id="user-role">
                            <option selected>権限</option>
                            <option value="1">管理者</option>
                            <option value="2">編集者</option>
                            <option value="3">閲覧者</option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" id="department">
                            <option selected>部署</option>
                            <option value="1">営業部</option>
                            <option value="2">商品開発部</option>
                            <option value="3">商品管理部</option>
                            <option value="3">その他</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        </div>
</form>