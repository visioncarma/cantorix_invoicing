<table class="table table-striped roles-table totalcredit">
    <tr></tr>
    <tr class="even-strip">
        <td colspan="4" class="title textright width-100-new">Amount to Credit</td>
        <td class="title textright width120"><?php echo $this->Number->currency($totalAmount,$currencyCode);?></td>
    </tr>
</table>
<table class="table table-striped roles-table totalcredit">
    <tr></tr>
    <tr class="even-strip">
        <td colspan="4" class="title textright width-100-new">Remaining credits</td>
        <td class="title textright width120"><?php echo $this->Number->currency(($creditBalance - $totalAmount),$currencyCode);?></td>
    </tr>
</table>