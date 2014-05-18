<div id="tshirts" class="blueSidebar">

    <h3>Official T-Shirts</h3>

    <p>By popular demand we have decided to offer our Recording Question t-shirts for sale to help support the community.</p>

    <?php echo image_tag('paypal-tshirt.jpg', array('style' => 'margin-left:30px')) ?>

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="hosted_button_id" value="10564451">
        <table>
        <tr><td><input type="hidden" name="on0" value="Color">Color</td></tr><tr><td><select name="os0">
                <option value="White">White $12.99</option>
                <option value="Black">Black $12.99</option>
        </select> </td></tr>
        <tr><td><input type="hidden" name="on1" value="Size">Size</td></tr><tr><td><select name="os1">
                <option value="Small">Small </option>
                <option value="Medium">Medium </option>
                <option value="Large">Large </option>
                <option value="Extra Large">Extra Large </option>
        </select> </td></tr>
        </table>
        <input type="hidden" name="currency_code" value="USD">
        <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>

</div>