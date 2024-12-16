<form action="{{ url('/users/search') }}" method="get" class="d-flex flex-wrap gap-2 mb-3 ps-2">
            @csrf       
            <div class="flex-grow-3">
                <input class="form-control mb-2 mr-3 keyword" type="search" name="sKeywords" placeholder="キーワード　検索"
                    value="{{ request('sKeywords') }}">
                <div class="search-content">
                    <p class="mini-title">絞り込み：</p>
                    <select class="form-select me-2 w-auto" name="sRole">
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
                    <select class="form-select w-auto" name="sDepartment">
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
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        
</form>