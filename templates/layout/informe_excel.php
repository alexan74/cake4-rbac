<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
//header ("Content-type: application/vnd.ms-excel");
header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header ("Content-Disposition: attachment; filename=$archivo.xls" );
header ("Content-Description: Reporte" );

print '<?xml version="1.0"?>'.chr(10);
print '<?mso-application progid="Excel.Sheet"?>'.chr(10);
?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
	<Styles>
  		<Style ss:ID="Default" ss:Name="Normal">
		   <Alignment ss:Horizontal="Left" ss:WrapText="1" />
		   <Borders/>
		   <Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12" ss:Color="#000000"/>
		   <Interior/>
		   <NumberFormat/>
		   <Protection/>
		</Style>
		<Style ss:ID="Encabezado">
	  	   	<Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
	  	   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="16" ss:Color="#000000"/>
		   	<Interior ss:Color="#FFFFFF" ss:Pattern="Solid" />
	  	</Style>
		<Style ss:ID="EncabezadoInforme">
	  	   	<Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
			<Borders>
				<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
		   	</Borders>
	  	   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="14" ss:Color="#000000"/>
		   	<Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
	  	</Style>
		<Style ss:ID="TituloInforme">
	  	   	<Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
			<Borders>
				<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#c3c3c3"/>
		   	</Borders>
		   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12" ss:Color="#000000" ss:Bold="1"/>
	  	</Style>
	  	<Style ss:ID="TituloColumna">
	  	   	<Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
			<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12" ss:Color="#ffffff"/>
			<Interior ss:Color="#428bca" ss:Pattern="Solid" />
		</Style>
		<Style ss:ID="PieCuadro">
			<Alignment ss:Horizontal="Left" ss:Vertical="Bottom"/>
			<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="8" ss:Color="#000000"/>
		</Style>
		<Style ss:ID="FormatoStringDerecha">
		   <Alignment ss:Horizontal="Right" />
		   <NumberFormat/>
		</Style>
	    <Style ss:ID="FormatoNumerico2">
		   <NumberFormat/>
		</Style>		
		<Style ss:ID="FormatoNumerico">
		   <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="CuadroEnmiendas">
		   	<Interior ss:Color="#FFCC99" ss:Pattern="Solid"/>
	  	</Style>
	  	<Style ss:ID="color1">
		   <Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		   <Interior ss:Color="#E1E1E1" ss:Pattern="Solid"/>
		   <Alignment ss:WrapText="1"/>
		   <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="color2">
			<Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		    <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
		    <Alignment ss:WrapText="1"/>
		    <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="border-top">
		   <Borders>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		   <Alignment ss:WrapText="1"/>
		   <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="Negrita">
	  	   	<Alignment ss:Horizontal="Left" />
		   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12" ss:Color="#000000" ss:Bold="1" />
	  	</Style>
	  	<Style ss:ID="NegritaCentrada">
	  	   	<Alignment ss:Horizontal="Center" />
		   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="12" ss:Color="#000000" ss:Bold="1" />
		   	<Interior ss:Color="#c3c3c3" ss:Pattern="Solid" />
		   	<Borders>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
	  	</Style>
	  	<Style ss:ID="Separador">
		   	<Interior ss:Color="#E4C600" ss:Pattern="Solid" />
	  	</Style>
	  	<Style ss:ID="TextWrap">
		    <Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
		</Style>
	  	
	</Styles> 	
 	
	<?php print $content_for_layout; ?>
	
</Workbook>	