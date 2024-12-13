<form action="{{ url('/users/search') }}" method="get">
            @csrf
        @if(!empty($searchError))
            <p>{{ $searchError }}</p>
        @endif
        <div class="d-inline-flex mb-3">
            <div class="d-flex flex-column">
                <input class="form-control" type="search" name="sKeywords" placeholder="キーワード　検索"
                    value="{{ isset($sKeywords) ? $sKeywords : '' }}">

                <div class="search-content d-flex">
                    <p class="mini-title">絞り込み：</p>
                    <div class="form-floating">
                        <select class="form-select" name="sSalesStatus">
                            @if(isset($sSalesStatus))
                            <option value="{{ $sSalesStatus }}" selected>{{ $types[$sSalesStatus] }}</option>
                            <option value="">販売状況を選択</option>
                            @else
                            <option value="" selected>販売状況を選択</option>
                            @endif
                            <option value="1">発売中</option>
                            <option value="2"></option>
                            <option value="3"></option>
                        </select>
                    </div>
                    <div class="form-floating">
                        <select class="form-select" name="sStockStatus">
                            @if(isset($sStockStatus))
                            <option value="{{ $sStockStatus }}" selected>{{ $stockStatuses[$sStockStatus] }}</option>
                            <option value="">在庫状況を選択</option>
                            @else
                            <option value="" selected>在庫状況を選択</option>
                            @endif
                            <option value="1">在庫あり</option>
                            <option value="2">在庫なし</option>
                        </select>
                    </div>
                </div>
                
            </div>
            <button class="btn btn-secondary align-self-start" type="submit">検索</button>
        </div>
</form>