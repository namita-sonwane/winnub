<div class="row">
    <div class="col-xs-12">

        <form action="/<?=getLanguage()?>/prodotti/savecategoria" method="post" class="">

                
                <div class="form-group">
                    <label for="nomeCategoria"><?=t("Nome categoria")?></label>
                    <input type="text" class="form-control" id="nomeCategoria" placeholder="Nome" name="nomecategoria">
                </div> 
                
            
                <div class="form-group">
                <?php
                
                   $gruppi=_getGruppiCategorie();
                    
                ?>
                    <label for="nomeCategoria"><?=t("Seleziona un gruppo")?></label>
                    
                    <select name='gruppo' class='form-control'>
                        <option value='product'><?=t("Prodotti")?></option>
                        <?php 
                        
                        foreach($gruppi as $nome){
                   ?>
                        <option value='<?=strtolower($nome["gruppo"])?>'><?=ucfirst($nome["gruppo"])?></option>
                        <?php }
                        
                        ?>
                    </select>
                    oppure 
                    <input type="text" class="form-control" name="grupponew" placeholder="<?=t("Nuovo gruppo")?>">
                    
                    <input type="hidden" name="codice" value="" id="codicecategoria" />
                    
                </div>
                
         
            
            <input type="hidden" name="referarl" value="" />
         </form>
    </div>
</div>