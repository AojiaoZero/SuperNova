<table width="530">
  <tr>
    <td colspan="2" class="c">{L_sys_dark_matter}</td>
  </tr>

  <tr>
    <th width="120" ><img src="design/images/DMaterie.jpg" width="120" height="120"></th>
    <th width="314" >
      <p align="justify">{L_sys_dark_matter_desc}</p>
      <div>
        <div class="fl"><img src="design/images/dm_klein_1.jpg"></div>
        <div align="left" id="sys_dark_matter_hint">{L_sys_dark_matter_hint}</div>
      </div>
      <A HREF="dark_matter.php" id="off_get_dark_matter">{L_sys_dark_matter_get}</A>
    </th>
  </tr>

  <tr>
    <td width="535" colspan="2" class="c">{L_tech[1000]}</td>
  </tr>

  <!-- BEGIN artifact -->
    <tr>
      <th width=120>
        {artifact.NAME}<br>
        <img src="{dpath}gebaeude/{artifact.ID}.jpg" align="top" width="120" height="120" /><br>
        <!-- IF artifact.LEVEL -->
          <div><a href="artifacts.php?action={D_ACTION_USE}&unit_id={artifact.ID}"><span class="warning">{L_art_use}</span></a></div>
        <!-- ENDIF -->
      </th>

      <th align=justify>
        {artifact.DESCRIPTION}<br><br>
        <div align="center">
          <div class="positive" align="center">{artifact.BONUS}&nbsp;{artifact.EFFECT}</div><br />
          <div>{L_sys_quantity}:&nbsp;{artifact.LEVEL}<!-- IF artifact.LEVEL_MAX -->/{artifact.LEVEL_MAX}<!-- ENDIF --></div>
          <!-- IF artifact.LEVEL_MAX && (artifact.LEVEL >= artifact.LEVEL_MAX) -->
            <span class="negative">{L_sys_quantity_maximum}</span>
          <!-- ELSEIF artifact.CAN_BUY <= 0 -->
            <span class="negative">{L_sys_buy_for} {artifact.COST} {L_sys_dark_matter_sh} - {L_sys_eco_lack_dark_matter}</span>
          <!-- ELSE -->
            <a href="artifacts.php?action={D_ACTION_BUY}&unit_id={artifact.ID}"><span class="positive">{L_sys_buy_for} {artifact.COST} {L_sys_dark_matter_sh}</span></a>
          <!-- ENDIF -->
        </div>
      </th>
    </tr>
  <!-- END artifact -->
</table>

<!-- INCLUDE page_hint.tpl -->
