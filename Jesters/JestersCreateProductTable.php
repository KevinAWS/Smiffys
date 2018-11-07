<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

$link = mssql_connect('213.171.218.223','matt','flair472b');

if(!$link)
{
	echo "Failed to connected to database" . "<br />";
}
else
{
	echo "Connected to database" . "<br />";	
	
	if(mssql_select_db('smarthlsql7', $link))
	{	
		if(!mssql_query('DROP TABLE jps_smiffys_product'))
		{
		   echo "failed to drop table jps_smiffys_product" . "<br />";	
		}

		if(!mssql_query('CREATE TABLE jps_smiffys_product 
						(ProductCode char(50) NOT NULL,		
						ProductName nvarchar(max) NULL,
						BrochureDescription nvarchar(max) NULL,
						WebDescription nvarchar(max) NULL,
						WashingInstructions nvarchar(max) NULL,
						RRP float NULL,
						StockQuantity int NULL,
						VatRate float NULL,
						Gender nvarchar(max) NULL,
						PackType nvarchar(max) NULL,
						PackQty int NULL,
						Audience nvarchar(max) NULL,
						FurtherDetails nvarchar(max) NULL,
						Colour nvarchar(max) NULL,		
						ETA nvarchar(max) NULL, 
						CataloguePage nvarchar(max) NULL,
						BarCode nvarchar(max) NULL,
						Price1 float NULL,
						Price2 float NULL,
						Price3 float NULL,
						Break1 float NULL,
						Break2 float NULL,
						Break3 float NULL,
						unit_size nvarchar(max) NULL,
						warnings nvarchar(max) NULL,	
						carton nvarchar(max) NULL,
						stdPrice1 float NULL,
						stdPrice2 float NULL,
						stdPrice3 float NULL,
						stdBreak1 float NULL,
						stdBreak2 float NULL,
						stdBreak3 float NULL,
						Photo nvarchar(max) NULL,
						SideShot nvarchar(max) NULL, 
						FrontShot nvarchar(max) NULL, 
						BackShot nvarchar(max) NULL, 
						CatalogueCode nvarchar(max) NULL,
						CatalogueName nvarchar(max) NULL,
						Catalogue nvarchar(max) NULL,
						acc_code1 nvarchar(max) NULL,
						acc_code2 nvarchar(max) NULL,
						acc_code3 nvarchar(max) NULL,
						acc_code4 nvarchar(max) NULL,
						acc_code5 nvarchar(max) NULL,
						alt_code1 nvarchar(max) NULL,
						alt_code2 nvarchar(max) NULL,
						alt_code3 nvarchar(max) NULL,
						alt_code4 nvarchar(max) NULL,
						alt_code5 nvarchar(max) NULL,
						new_code nvarchar(max) NULL,	
						art_cat nvarchar(max) NULL,
						Seasonal nvarchar(max) NULL,
						p_list2 nvarchar(max) NULL,	
						DropDate nvarchar(max) NULL, 
						Licence_Territory nvarchar(max) NULL,	
						ThemeName nvarchar(max) NULL,
						AdditionalTheme nvarchar(max) NULL,
						GroupID nvarchar(max) NULL,
						GroupName nvarchar(max) NULL,
						GroupID1 nvarchar(max) NULL,
						ThemeGroup1 nvarchar(max) NULL,
						GroupID2 nvarchar(max) NULL,
						ThemeGroup2 nvarchar(max) NULL,
						GroupID3 nvarchar(max) NULL,
						ThemeGroup3 nvarchar(max) NULL,
						EFPrice float NULL,
						EFQty int NULL,
						Size nvarchar(max) NULL,
						Ext_Size nvarchar(max) NULL,
						GenericCode nvarchar(max) NULL,
						UNIQUE(ProductCode))'))		
		   {
			   echo "failed to create table jps_smiffys_product" . "<br />";	
		   }
		   else
		   {
			   echo "Created table jps_smiffys_product" . "<br />";	
		   }
			   
			
		if(mssql_close($link)==TRUE)
		{
			echo "Closed link" . "<br />";
		}
	}
}

?>