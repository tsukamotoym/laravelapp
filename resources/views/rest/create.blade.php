<table>
  <form action="/rest" method="post">
    {{ csrf_field() }}
    <tr><th>message: </th><td><input type="text" name="message" value="{{old('message')}}"></td></tr>
    <tr><th>URL: </th><td><input type="text" name="url" value="{{old('url')}}"></td></tr>
    <tr><th></th><td><input type="submit" value="追加"></td></tr>
  </form>
</table>
