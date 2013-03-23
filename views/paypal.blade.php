@layout('pec::template')

@section('content')
<form class="form-horizontal" method="post" action="paypal">
        <fieldset>
          <legend>Galaxy Jewel Chocolates</legend>
         <input type="hidden" name="itemname" value="Product One" /> 
	 <input type="hidden" name="itemnumber" value="1" /> 
         <input type="hidden" name="itemprice" value="10" />
        
          <div class="control-group">
            <label class="control-label" for="select01">Quantity</label>
            <div class="controls">
              <select name="itemQty" id="select01">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>               
              </select>
                <input class="btn btn-primary" type="submit" name="submitbutt" value="Buy (10 {{ Config::get('cartify::options.paypalcurrencycode') }})" />

                   </div>             
          </div>  
        </fieldset>
</form>

<form class="form-horizontal" method="post" action="paypal">
        <fieldset>
         <legend>Gold Coin Chocolates</legend>
        <input type="hidden" name="itemname" value="Product Two" /> 
	<input type="hidden" name="itemnumber" value="2" /> 
	<input type="hidden" name="itemprice" value="20" />
          <div class="control-group">
            <label class="control-label" for="select01">Quantity</label>
            <div class="controls">
              <select name="itemQty" id="select01">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>     
              </select>
              <input class="btn btn-primary" type="submit" name="submitbutt" value="Buy (20 {{ Config::get('cartify::options.paypalcurrencycode') }})" />
 </div>             
          </div>  
        </fieldset>
</form>
@endsection