<form action="{{ url('/users/search') }}" method="get">
            @csrf
        @if(!empty($searchError))
            <p>{{ $searchError }}</p>
        @endif
        <div class="d-inline-flex mb-3">
            <div class="d-flex flex-column">
                <input class="form-control" type="search" name="sKeywords" placeholder="キーワード　検索"
                    value="{{ request('sKeywords') }}">

                <div class="search-content d-flex">
                    <p class="mini-title">絞り込み：</p>
                    <div class="form-floating">
                        <select class="form-select" name="sRole">
                            @if(!empty(request('sRole')))
                            <option value="{{ request('sRole') }}" selected>{{ $roles[request('sRole')] }}</option>
                            <option value="">権限を選択</option>
                            @else
                            <option value="" selected>権限を選択</option>
                            @endif
                            <option value="1">管理者</option>
                            <option value="2">編集者</option>
                            <option value="3">閲覧者</option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" name="sDepartment">
                            @if(!empty(request('sDepartment')))
                            <option value="{{ request('sDepartment') }}" selected>{{ $departments[request('sDepartment')] }}</option>
                            <option value="">部署を選択</option>
                            @else
                            <option value="" selected>部署を選択</option>
                            @endif
                            <option value="1">商品管理部</option>
                            <option value="2">営業部</option>
                            <option value="3">商品開発部</option>
                            <option value="4">その他</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        </div>
</form>