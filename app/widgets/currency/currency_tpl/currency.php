<a href="#"><?=$this->currency['code']?></a>
<ul class="dropdown-container" id="currency">
    <?php foreach ($this->currencies as $k => $v): ?>
    <li <?php if( $k == $this->currency['code']) echo  'class="active"'; ?>>
        <a href="<?=PATH?>/currency/change?curr=<?=$k?>"><?=$k?></a>
    </li>
    <?php endforeach; ?>
</ul>
