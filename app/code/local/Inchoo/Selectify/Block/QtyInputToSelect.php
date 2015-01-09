<?php
class Inchoo_Selectify_Block_QtyInputToSelect extends Mage_Core_Block_Text
{
    protected $_nameInLayout = 'selectify.qty_input_to_select';
    protected $_alias = 'qty_input_to_select';
 
    public function setPassingTransport($transport)
    {
        $this->setData('text', $transport.$this->_generateQtyInputToSelectHtml());
    }
 
    private function _generateQtyInputToSelectHtml()
    {
        return '
            <script type="text/javascript">
            //<![CDATA[
 
            document.observe("dom:loaded", function() {
                $("qty").replace(\'<select class="input-text qty" title="Qty" value="1" id="qty" name="qty"><option selected="selected" value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>\');
            });
 
            //]]>
            </script>
        ';
    }
}