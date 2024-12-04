<form action="#" method="GET">
            @csrf
        <div class="d-inline-flex mb-3">
            <div class="d-flex flex-column">
                <input class="form-control" type="search" name="query" placeholder="フリーワード検索"
                    value="{{ request('query') }}">
                <div class="categoryChecks d-flex">
                    <p class="mini-title">ジャンル：</p>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category[]" value="1"
                            id="searchFor1"
                            {{ is_array(request('category')) && in_array(1, request('category')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="searchFor1">
                            RPG　
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category[]" value="2"
                            id="searchFor2"
                            {{ is_array(request('category')) && in_array(2, request('category')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="searchFor2">
                            対戦　
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category[]" value="3"
                            id="searchFor3"
                            {{ is_array(request('category')) && in_array(3, request('category')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="searchFor3">
                            育成　
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category[]" value="4"
                            id="searchFor4"
                            {{ is_array(request('category')) && in_array(4, request('category')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="searchFor4">
                            パーティ　
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="category[]" value="5"
                            id="searchFor5"
                            {{ is_array(request('category')) && in_array(5, request('category')) ? 'checked' : '' }}>
                        <label class="form-check-label" for="searchFor5">
                            その他　
                        </label>
                    </div>
                </div>
                <div class="search-content d-flex">
                    <p class="mini-title">絞り込み：</p>
                    <div class="form-floating">
                        <select class="form-select" id="sale-status">
                            <option selected>販売状況</option>
                            <option value="1">販売中</option>
                            <option value="2">生産終了</option>
                            <option value="3">未定</option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" id="leftover">
                            <option selected>在庫状況</option>
                            <option value="1">〇</option>
                            <option value="2">△</option>
                            <option value="3">×</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex">
                        <p class="mini-title">対象期間：</p>
                        <input type="date" name="from" placeholder="from_date" value="">
                            <span class="mx-3">～</span>
                        <input type="date" name="until" placeholder="until_date" value="">
                </div>
            </div>
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        </div>
</form>