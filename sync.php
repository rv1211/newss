<?php
echo Date('Y-m-d H:i:s');
exit;
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);
require('config.php');
error_reporting(E_ALL);
//create object of QBSync class
if (!function_exists('getallheaders')) {
    function getallheaders() {
    $headers = array();
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
    }
}
$qb = new DBSync();
$action = $_SERVER['REQUEST_METHOD'];

$headersDetail=array();
foreach (getallheaders() as $name => $value) {
    $headersDetail[$name] = $value;
}

//if(isset($headersDetail['Action']) && isset($headersDetail['Username']))
if(isset($headersDetail['Action']))
  $action = $headersDetail['Action'];


switch ($action){
    case 'company':
        $qb->company();
        $qb->closeConnection();
        break;
      case 'getSalesrep':
        $qb->getSalesrep();
        $qb->closeConnection();
        break;
      case 'updateSalesRep':
        $qb->updateSalesRep();
        $qb->closeConnection();
        break;
    case 'account':
        $qb->account();
        $qb->closeConnection();
        break;
     case 'item':
        $qb->item();
        $qb->closeConnection();
        break;
      case 'salesTaxItem':
        $qb->salesTaxItem();
        $qb->closeConnection();
        break;
      case 'salesTaxItemGroup':
        $qb->salesTaxItemGroup();
        $qb->closeConnection();
        break;
      case 'salesTaxCode':
        $qb->salesTaxCode();
        $qb->closeConnection();
        break;
      case 'get_inhistory':
        $qb->inHistory();
        $qb->closeConnection();
        break;
      case 'salesRep':
        $qb->salesRep();
        $qb->closeConnection();
        break;
      case 'shipMethod':
        $qb->shipMethod();
        $qb->closeConnection();
        break;
      case 'terms':
        $qb->terms();
        $qb->closeConnection();
        break;
       case 'customer':
        $qb->customer();
        $qb->closeConnection();
        break;
      case 'customerType':
        $qb->customerType();
        $qb->closeConnection();
        break;
      case 'get_invoicesync':
        $qb->getInvoiceSync();
        $qb->closeConnection();
        break;
      case 'get_customer':
        $qb->getCustomer();
        $qb->closeConnection();
        break;
      case 'up_customerSync':
        $qb->upCustomerIsSync();
        $qb->closeConnection();
        break;
      case 'get_item':
        $qb->getItems();
        $qb->closeConnection();
        break;
      case 'updateInvoice':
        $qb->updateInvoice();
        $qb->closeConnection();
        break;
      case 'updateItem':
        $qb->updateItem();
        $qb->closeConnection();
        break;
      case 'invoice':
        $qb->invoice();
        $qb->closeConnection();
        break;
       case 'inActiveInvoice':
        $qb->inActiveInvoice();
        $qb->closeConnection();
        break;
      case 'getCompanyDetail':
        $qb->getCompanyDetail();
        $qb->closeConnection();
        break;
      case 'get_invoiceLineSync':
        $qb->getInvoiceLineSync();
        $qb->closeConnection();
        break;
      case 'get_history':
        $qb->getHistory();
        $qb->closeConnection();
        break;
      case 'updateCustomerSaledate':
        $qb->updateCustomerSaledate();
        $qb->closeConnection();
        break;
      case 'upCustomerContactListId':
        $qb->upCustomerContactListId();
        $qb->closeConnection();
        break;
      case 'getInvoiceDeleted':
        $qb->getInvoiceDeleted();
        $qb->closeConnection();
        break;
      case 'deleteInvoice':
        $qb->deleteInvoice();
        $qb->closeConnection();
        break;
       case 'deleteCustomer':
        $qb->deleteCustomer();
        $qb->closeConnection();
        break;
      case 'deleteItem':
        $qb->deleteItem();
        $qb->closeConnection();
        break;
       case 'getLastModifiedItem':
        $qb->getLastModifiedItem();
        $qb->closeConnection();
        break;
       case 'getLastModifiedCustomer':
        $qb->getLastModifiedCustomer();
        $qb->closeConnection();
        break;
      case 'qbupdate_history':
        $qb->qbupdate_history();
        $qb->closeConnection();
        break;
        case 'get_qbhistory':
        $qb->get_qbhistory();
        $qb->closeConnection();
        break;
    default:
        $arr[] = array('success' => 0, 'message' => "Error in post data");
        echo json_encode($arr);exit;
}
exit;

class DBSync{
  private $dataService;
  function __construct()
  {
    $this->connect = new Connect();
  }
  function company()
  {
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post[0];
      $query="SELECT ID FROM companymaster WHERE MacID='".base64_decode($_Detail->MacID)."'"; 
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `companymaster` SET 
                      Name="'.base64_decode($_Detail->Name).'",
                      QbCompanyPath="'.base64_decode($_Detail->QbCompanyPath).'",
                      SDkVersion="'.base64_decode($_Detail->SDkVersion).'",
                      MacID="'.base64_decode($_Detail->MacID).'",
                      IsSync="'.trim($_Detail->IsSync).'"
                    WHERE ID="'.$p_row['ID'].'"';
          $data = $this->connect->Execute($query);
          if($data){
            $arr[] = array('success' => 1, 'message' => "Company updated Successfully", 'ID' =>$p_row['ID']);
          }else{
            $arr[] = array('success' => 0, 'message' => "Fail ! Company not updated","ID" => $p_row['ID']);
          }
      }else{
        $query = 'INSERT INTO `companymaster`(
                      Name,
                      QbCompanyPath,
                      SDkVersion,
                      MacID,
                      IsSync
                      ) values(
                        "'.base64_decode($_Detail->Name).'",
                        "'.base64_decode($_Detail->QbCompanyPath).'",
                        "'.base64_decode($_Detail->SDkVersion).'",
                        "'.base64_decode($_Detail->MacID).'",
                        "'.trim($_Detail->IsSync).'"                        
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Company insert successfully", 'ID' =>$this->connect->getInsertedId());
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Company not insert","ID" => $this->connect->getInsertedId());
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  
   function getSalesrep(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query="SELECT * FROM salesrep WHERE IsSync=0 AND CompanyID=".$post[0]['CompanyId']; 
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          while($rows=mysqli_fetch_assoc($data)){
            $p_row[]=$rows;
          }
          $arr = $p_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }

  function account(){
    $post=file_get_contents('php://input');
      if(isset($post) && $post!=''){
        $post=json_decode($post,true);
        $_Detail=$post[0];
         if($_Detail['ListId'] != ""){        

            //check with model number and parentID
            $query="SELECT id FROM account WHERE ListId = '".base64_decode($_Detail['ListId'])."' AND companyId = '".trim($_Detail['companyId'])."'";
            $data = $this->connect->Execute($query);
             if($this->connect->getAffectedRow() > 0){
                $p_row=mysqli_fetch_assoc($data);
              //update 
              $query = 'UPDATE account set 
                name = "'.base64_decode($_Detail['name']).'",
                account_number = "'.base64_decode($_Detail['account_number']).'",
                type = "'.base64_decode($_Detail['type']).'",
                companyId = "'.trim($_Detail['companyId']).'" WHERE id="'.$p_row['id'].'"';
                $data = $this->connect->Execute($query);
                if($data){
                  $arr[] = array('success' => 1, 'message' => "Account update successfully", 'name' =>base64_decode($_Detail['name']));
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Account not update","name" => base64_decode($_Detail['name']));
                }
            }else{
              //insert
              $query = 'INSERT INTO `account`(
                        name,
                        account_number,
                        type,
                        companyId,
                        ListId
                        ) values(
                          "'.base64_decode($_Detail['name']).'",
                          "'.base64_decode($_Detail['account_number']).'",
                          "'.base64_decode($_Detail['type']).'",
                          "'.trim($_Detail['companyId']).'",
                          "'.base64_decode($_Detail['ListId']).'"
                        )';

                $data = $this->connect->Execute($query);
                if($data){
                  $arr[] = array('success' => 1, 'message' => "Account insert successfully", 'name' =>base64_decode($_Detail['name']));
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Account not insert","name" => base64_decode($_Detail['name']));
                }
            }
          
         }else{
           $arr[] = array('success' => 0, 'message' => "Error: List id is empty!!!");
      }
        
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function item(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post[0];
      $query_set="SET SQL_BIG_SELECTS=1;";
      $this->connect->Execute($query_set);
      $query="SELECT Id from itemmaster WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
        $query = 'UPDATE `itemmaster` SET 
                      ListID = "'.trim($_Detail->ListID).'",
                      Name="'.base64_decode(trim($_Detail->Name)).'",
                      FullName="'.base64_decode(trim($_Detail->FullName)).'",
                      IsActive="'.trim($_Detail->IsActive).'",
                      ClassName="'.base64_decode(trim($_Detail->ClassName)).'",
                      ParentListID="'.trim($_Detail->ParentListID).'",
                      ParentName="'.base64_decode(trim($_Detail->ParentName)).'",
                      ManufacturePartNumber="'.base64_decode($_Detail->ManufacturePartNumber).'",
                      SalesDesc="'.base64_decode(trim($_Detail->SalesDesc)).'",
                      SalesPrice="'.trim($_Detail->SalesPrice).'",
                      IncomeAccount="'.base64_decode(trim($_Detail->IncomeAccount)).'",
                      PurchaseDesc="'.base64_decode(trim($_Detail->PurchaseDesc)).'",
                      PurchaseCost="'.trim($_Detail->PurchaseCost).'",
                      COGSAccount="'.base64_decode(trim($_Detail->COGSAccount)).'",
                      AssetAccount="'.base64_decode(trim($_Detail->AssetAccount)).'",
                      QuantityOnHand="'.trim($_Detail->QuantityOnHand).'",
                      QuantityOnOrder="'.trim($_Detail->QuantityOnOrder).'",
                      CompanyID="'.trim($_Detail->CompanyID).'",
                      SalesTaxCode="'.base64_decode(trim($_Detail->SalesTaxCode)).'",
                      PrefVendorName="'.base64_decode(trim($_Detail->PrefVendorName)).'",
                      AverageCost="'.trim($_Detail->AverageCost).'",
                      IsTaxIncluded="'.trim($_Detail->IsTaxIncluded).'",
                      PurchaseTaxCodeRef="'.base64_decode($_Detail->PurchaseTaxCodeRef).'",
                      IsSync="'.trim($_Detail->IsSync).'"
                    WHERE Id="'.$p_row['Id'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Item updated Successfully", 'ListID' =>$_Detail->ListID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Item not updated","ListID" => $_Detail->ListID);
        }
      }else{
         $IsActive = trim($_Detail->IsActive);
         $query = 'INSERT INTO `itemmaster`(
                      ListID,
                      Name,
                      FullName,
                      IsActive,
                      ClassName,
                      ParentListID,
                      ParentName,
                      ManufacturePartNumber,
                      SalesDesc,
                      SalesPrice,
                      IncomeAccount,
                      PurchaseDesc,
                      PurchaseCost,
                      COGSAccount,
                      AssetAccount,
                      QuantityOnHand,
                      QuantityOnOrder,
                      CompanyID,
                      SalesTaxCode,
                      PrefVendorName,
                      AverageCost,
                      IsTaxIncluded,
                      PurchaseTaxCodeRef,
                      IsSync
                      ) values(
                        "'.$_Detail->ListID.'",
                        "'.base64_decode(trim($_Detail->Name)).'",
                        "'.base64_decode(trim($_Detail->FullName)).'",
                        "'.$IsActive.'",
                        "'.base64_decode(trim($_Detail->ClassName)).'",
                        "'.trim($_Detail->ParentListID).'",
                        "'.base64_decode(trim($_Detail->ParentName)).'",
                        "'.base64_decode($_Detail->ManufacturePartNumber).'",
                        "'.base64_decode(trim($_Detail->SalesDesc)).'",
                        "'.trim($_Detail->SalesPrice).'",
                        "'.base64_decode(trim($_Detail->IncomeAccount)).'",
                        "'.base64_decode(trim($_Detail->PurchaseDesc)).'",
                        "'.trim($_Detail->PurchaseCost).'",
                        "'.base64_decode(trim($_Detail->COGSAccount)).'",
                        "'.base64_decode(trim($_Detail->AssetAccount)).'",
                        "'.trim($_Detail->QuantityOnHand).'",
                        "'.trim($_Detail->QuantityOnOrder).'",
                        "'.trim($_Detail->CompanyID).'",
                        "'.base64_decode(trim($_Detail->SalesTaxCode)).'",
                        "'.base64_decode(trim($_Detail->PrefVendorName)).'",
                        "'.trim($_Detail->AverageCost).'",
                        "'.trim($_Detail->IsTaxIncluded).'",
                        "'.base64_decode($_Detail->PurchaseTaxCodeRef).'",
                        "'.trim($_Detail->IsSync).'"
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "ItemInsert successfully", 'ListID' =>base64_decode($_Detail->Name));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Item not insert","ListID" => base64_decode($_Detail->Name));
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function salesTaxItem(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post[0];
      $query="SELECT ID FROM salestaxitemmaster WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          //update
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `salestaxitemmaster` SET 
                      Name="'.base64_decode($_Detail->Name).'",
                      Description="'.base64_decode($_Detail->Description).'",
                      Rate="'.trim($_Detail->Rate).'",
                      ListID="'.trim($_Detail->ListID).'",
                      IsSync="'.trim($_Detail->IsSync).'",
            IsActive="'.trim($_Detail->IsActive).'"
                    WHERE ID="'.$p_row['ID'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salestax item updated Successfully", 'ID' =>base64_decode($_Detail->Name));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salestax item not updated","ID" => base64_decode($_Detail->Name));
        }
      }else
      {
        //Insert
        $query = 'INSERT INTO `salestaxitemmaster`(
                      Name,
                      Description,
                      Rate,
                      ListID,
                      IsSync,
                      IsActive,
                      CompanyID) values(
                        "'.base64_decode($_Detail->Name).'",
                        "'.base64_decode($_Detail->Description).'",
                        "'.trim($_Detail->Rate).'",
                        "'.trim($_Detail->ListID).'",
                        "'.trim($_Detail->IsSync).'",
                        "'.trim($_Detail->IsActive).'",
            "'.trim($_Detail->CompanyID).'"         
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salestax item insert successfully", 'ListID' =>base64_decode($_Detail->Name));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salestax item not insert","ListID" => base64_decode($_Detail->Name));
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function salesTaxItemGroup(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $_Detail=$post[0];
      $query="SELECT id FROM salestaxgroup WHERE ListId='".$_Detail['ListId']."' AND CompanyID='".$_Detail['CompanyID']."'"; 
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `salestaxgroup` set 
                      ListId = "'.trim($_Detail['ListId']).'",
                      groupName = "'.trim(base64_decode($_Detail['groupName'])).'",
                      CompanyID = "'.trim($_Detail['CompanyID']).'",
                      IsSync =  "'.trim($_Detail['IsSync']).'",
                      IsActive = "'.trim($_Detail['IsActive']).'" 
                      where id="'.$p_row['id'].'"';
            $data = $this->connect->Execute($query);
            $del_query = 'DELETE from `salestaxgroupdetail` where groupId='.trim($p_row['id']);
            $this->connect->Execute($del_query);
            if(count($_Detail['ItemDetail']) > 0){
              foreach ($_Detail['ItemDetail'] as $key => $value) {
                  $query = 'INSERT INTO `salestaxgroupdetail`(
                        groupId,
                        itemName,
                        itemListId) values(
                          "'.trim($p_row['id']).'",
                          "'.trim(base64_decode($value['itemName'])).'",
                          "'.trim($value['itemListId']).'"    
                        )';
               $data = $this->connect->Execute($query);
              }
            }
             $arr[] = array('success' => 1, 'message' => "Updated successfully", 'groupId' =>$p_row['id']);
      }else{
        $query = 'INSERT INTO `salestaxgroup`(
                      ListId,
                      groupName,
                      CompanyID,
                      IsSync,
                      IsActive) values(
                        "'.trim($_Detail['ListId']).'",
                        "'.trim(base64_decode($_Detail['groupName'])).'",
                        "'.trim($_Detail['CompanyID']).'",
                        "'.trim($_Detail['IsSync']).'",
                        "'.trim($_Detail['IsActive']).'"    
                      )';
        $data = $this->connect->Execute($query);
        $insertedId = $this->connect->getInsertedId();
        if($insertedId > 0){
          if(count($_Detail['ItemDetail']) > 0){
            foreach ($_Detail['ItemDetail'] as $key => $value) {
                $query = 'INSERT INTO `salestaxgroupdetail`(
                      groupId,
                      itemName,
                      itemListId) values(
                        "'.trim($insertedId).'",
                        "'.trim(base64_decode($value['itemName'])).'",
                        "'.trim($value['itemListId']).'"    
                      )';
             $data = $this->connect->Execute($query);
            }
          }
           //$arr[] = array('success' => 1, 'message' => "SalesTaxGroup insert successfully", 'groupId' =>$insertedId);
        }else{
           $arr[] = array('success' => 0, 'message' => "Fail ! SalesTaxGroup not insert", 'groupId' =>$insertedId);
        }
        $arr[] = array('success' => 1, 'message' => "SalesTaxGroup insert successfully", 'groupId' =>$insertedId);
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
   function inHistory(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $_Detail=$post[0];
      if($_Detail['CompanyID'] != ""){
        $query = 'INSERT INTO `history`(
                      TranType,
                      TotalRec,
                      InsertRec,
                      UpdateRec,
                      SkipRec,
                      FailRec,
                      CreatedDate,
                      DeleteRec,
                      CompanyID) values(
                        "'.trim($_Detail['TranType']).'",
                        "'.trim($_Detail['TotalRec']).'",
                        "'.trim($_Detail['InsertRec']).'",
                        "'.trim($_Detail['UpdateRec']).'",
                        "'.trim($_Detail['SkipRec']).'",
                        "'.trim($_Detail['FailRec']).'",
                        "'.trim($_Detail['CreatedDate']).'",
                        "'.trim($_Detail['DeleteRec']).'",
                        "'.trim($_Detail['CompanyID']).'"      
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "History insert successfully", 'CompanyID' =>$_Detail['CompanyID']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! History not insert","CompanyID" => $_Detail['CompanyID']);
        }
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: History CompanyID is empty!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }

    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function salesTaxCode(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post[0];
      $query="SELECT ID FROM salestaxcode WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `salestaxcode` SET 
                      ListID="'.trim($_Detail->ListID).'",
                      Name="'.base64_decode($_Detail->Name).'",
                      Description="'.base64_decode($_Detail->Description).'",
                      IsTaxable="'.trim($_Detail->IsTaxable).'",
                      ItemPurchaseTaxListID="'.trim($_Detail->ItemPurchaseTaxListID).'",
                      ItemSalesTaxListID="'.trim($_Detail->ItemSalesTaxListID).'",
                      IsSync="'.trim($_Detail->IsSync).'",
                      IsActive="'.trim($_Detail->IsActive).'"
                    WHERE ID="'.$p_row['ID'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salestax code updated Successfully", 'ID' =>base64_decode($_Detail->Name));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salestax code not updated","ID" => base64_decode($_Detail->Name));
        }
      }else{
        $query = 'INSERT INTO `salestaxcode`(
                      ListID,
                      Name,
                      Description,
                      IsTaxable,
                      ItemPurchaseTaxListID,
                      ItemSalesTaxListID,
                      CompanyID,
                      IsSync,
                      IsActive) values(
                        "'.trim($_Detail->ListID).'",
                        "'.base64_decode($_Detail->Name).'",
                        "'.base64_decode($_Detail->Description).'",
                        "'.trim($_Detail->IsTaxable).'",
                        "'.trim($_Detail->ItemPurchaseTaxListID).'",
                        "'.trim($_Detail->ItemSalesTaxListID).'",
                        "'.trim($_Detail->CompanyID).'",
                        "'.trim($_Detail->IsSync).'",
                        "'.trim($_Detail->IsActive).'"        
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salestax code insert successfully", 'ListID' =>base64_decode($_Detail->Name));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salestax code not insert","ListID" => base64_decode($_Detail->Name));
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function updateSalesRep(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post[0];
      $query = 'UPDATE `salesrep` SET 
                      ListID="'.trim($_Detail->ListID).'",
                      SalesRepEntityRefListId="'.trim($_Detail->SalesRepEntityRefListId).'",
                      IsSync="1"
                    WHERE ID="'.$_Detail->ID.'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salesrep updated Successfully", 'ID' =>$_Detail->ID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salesrep not updated","ID" => $_Detail->ID);
        }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
   function salesRep(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post[0];
      $query="SELECT ID FROM salesrep WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `salesrep` SET 
                      ListID="'.trim($_Detail->ListID).'",
                      Initial="'.base64_decode($_Detail->Initial).'",
                      SalesRepEntityRefListId="'.trim($_Detail->SalesRepEntityRefListId).'",
                      SalesRepEntityRefName="'.base64_decode($_Detail->SalesRepEntityRefName).'",
                      IsActive="'.trim($_Detail->IsActive).'",
                      IsSync="1"
                    WHERE ID="'.$p_row['ID'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salesrep updated Successfully", 'ID' =>$p_row['ID']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salesrep not updated","ID" => $p_row['ID']);
        }
      }else{
        $query = 'INSERT INTO `salesrep`(
                      ListID,
                      Initial,
                      SalesRepEntityRefListId,
                      SalesRepEntityRefName,
                      IsActive,
                      IsSync,
                      CompanyID) values(
                        "'.trim($_Detail->ListID).'",
                        "'.base64_decode($_Detail->Initial).'",
                        "'.trim($_Detail->SalesRepEntityRefListId).'",
                        "'.base64_decode($_Detail->SalesRepEntityRefName).'",
                        "'.trim($_Detail->IsActive).'",
                        "1",
                        "'.trim($_Detail->CompanyID).'"
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Salesrep insert successfully", 'ListID' =>$_Detail->ListID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Salesrep not insert","ListID" => $_Detail->ListID);
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }

  function shipMethod(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post[0];
      $query="SELECT ID FROM shipmethod WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `shipmethod` SET 
                      ListID="'.trim($_Detail->ListID).'",
                      Name="'.base64_decode($_Detail->Name).'",
                      IsActive="'.trim($_Detail->IsActive).'"
                    WHERE ID="'.$p_row['ID'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Shipmethod updated Successfully", 'ID' =>$p_row['ID']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Shipmethod not updated","ID" => $p_row['ID']);
        }
      }else{
        $query = 'INSERT INTO `shipmethod`(
                      ListID,
                      Name,
                      IsActive,
                      CompanyID) values(
                        "'.trim($_Detail->ListID).'",
                        "'.base64_decode($_Detail->Name).'",
                        "'.trim($_Detail->IsActive).'",
                        "'.trim($_Detail->CompanyID).'"
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Shipmethod insert successfully", 'ListID' =>base64_decode($_Detail->ListID));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Shipmethod not insert","ListID" => base64_decode($_Detail->ListID));
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function terms(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post[0];
      $query="SELECT ID FROM terms WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `terms` SET 
                      ListID="'.trim($_Detail->ListID).'",
                      Name="'.base64_decode($_Detail->Name).'",
                      IsActive="'.trim($_Detail->IsActive).'"
                    WHERE ID="'.$p_row['ID'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Terms updated Successfully", 'ID' =>$p_row['ID']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Terms not updated","ID" => $p_row['ID']);
        }
      }else{
        $query = 'INSERT INTO `terms`(
                      ListID,
                      Name,
                      IsActive,
                      CompanyID) values(
                        "'.trim($_Detail->ListID).'",
                        "'.base64_decode($_Detail->Name).'",
                        "'.trim($_Detail->IsActive).'",
                        "'.trim($_Detail->CompanyID).'"
                      )';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Terms insert successfully", 'ListID' =>base64_decode($_Detail->ListID));
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Terms not insert","ListID" => base64_decode($_Detail->ListID));
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function customerType()
   {      
    $post=file_get_contents('php://input');
      if(isset($post) && $post!=''){
        $post=json_decode($post,true);
        $_Detail=$post[0];
         if($_Detail['ListId'] != ""){        

            //check with model number and parentID
             $query="SELECT id FROM customer_type WHERE ListId = '".base64_decode($_Detail['ListId'])."' AND companyId = '".trim($_Detail['CompanyId'])."'";
            $data = $this->connect->Execute($query);
             if($this->connect->getAffectedRow() > 0){
               
              //update 
              $query = 'UPDATE customer_type set 
                Name = "'.base64_decode($_Detail['Name']).'",
                ParentRefListID = "'.base64_decode($_Detail['ParentRefListID']).'",
                ParentRefName = "'.base64_decode($_Detail['ParentRefName']).'",
                CompanyId = "'.trim($_Detail['CompanyId']).'" WHERE ListId="'.base64_decode($_Detail['ListId']).'"';
                $data = $this->connect->Execute($query);
                if($data){
                  $arr[] = array('success' => 1, 'message' => "Customer Type update successfully", 'name' =>base64_decode($_Detail['Name']));
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Customer Type not update","name" => base64_decode($_Detail['Name']));
                }
            }else{
              //insert
              $query = 'INSERT INTO `customer_type`(
                        Name,
                        ParentRefListID,
                        ParentRefName,
                        CompanyId,
                        ListId
                        ) values(
                          "'.base64_decode($_Detail['Name']).'",
                          "'.base64_decode($_Detail['ParentRefListID']).'",
                          "'.base64_decode($_Detail['ParentRefName']).'",
                          "'.trim($_Detail['CompanyId']).'",
                          "'.base64_decode($_Detail['ListId']).'"
                        )';

                $data = $this->connect->Execute($query);
                if($data){
                  $arr[] = array('success' => 1, 'message' => "Customer Type insert successfully", 'name' =>base64_decode($_Detail['Name']));
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Customer Type not insert","name" => base64_decode($_Detail['Name']));
                }
            }
          
         }else{
           $arr[] = array('success' => 0, 'message' => "Error: List id is empty!!!");
      }
        
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function updateSubContacts($_SubDetail,$customerId){
    foreach ($_SubDetail as $key => $_SubDetailVal) 
    {
         $queryContact="SELECT id FROM customercontacts WHERE ListID='".base64_decode($_SubDetailVal->CustomListID)."' AND CompanyID='".$_SubDetailVal->CustomCompanyID."'";
        
        $data = $this->connect->Execute($queryContact);
        if($this->connect->getAffectedRow() > 0){
            $sub_row=mysqli_fetch_assoc($data);
             $queryContact = 'UPDATE `customercontacts` SET 
                        jobTitle="'.base64_decode($_SubDetailVal->CustomJobTitle).'",
                        FirstName="'.base64_decode($_SubDetailVal->CustomFirstName).'",
                        LastName="'.base64_decode($_SubDetailVal->CustomLastName).'",
                        cell_reg="'.base64_decode($_SubDetailVal->CustomCellNumber).'",
                        phone="'.base64_decode($_SubDetailVal->CustomPhone).'",
                        email="'.base64_decode($_SubDetailVal->CustomEmail).'",
                        fax="'.base64_decode($_SubDetailVal->CustomFax).'"
                      WHERE id="'.$sub_row['id'].'"';
          $data = $this->connect->Execute($queryContact);
         
        }else{

           $queryContact = 'INSERT INTO `customercontacts`(
                        customerId,
                        CompanyID,
                        ListId,
                        FirstName,
                        LastName,
                        jobTitle,
                        Phone,
                        cell_reg,
                        fax,
                        email,
                        createdBy
                        ) values(
                          "'.$customerId.'",
                          "'.$_SubDetailVal->CustomCompanyID.'",
                          "'.base64_decode($_SubDetailVal->CustomListID).'",
                           "'.base64_decode($_SubDetailVal->CustomFirstName).'",
                          "'.base64_decode($_SubDetailVal->CustomLastName).'",
                          "'.base64_decode($_SubDetailVal->CustomJobTitle).'",
                          "'.base64_decode($_SubDetailVal->CustomPhone).'",
                          "'.base64_decode($_SubDetailVal->CustomCellNumber).'",
                          "'.base64_decode($_SubDetailVal->CustomFax).'",
                          "'.base64_decode($_SubDetailVal->CustomEmail).'","1"             
                        )';
          $data = $this->connect->Execute($queryContact);
        }
        
      }
      return true;
  }
  function insertMainContact($_Detail,$customerId){
           $queryContact="SELECT id FROM customercontacts WHERE ListID='".trim($_Detail->ListID)."' AND CompanyID='".$_Detail->CompanyID."'";
        
        $data = $this->connect->Execute($queryContact);
        if($this->connect->getAffectedRow() > 0){
            $sub_row=mysqli_fetch_assoc($data);
             $queryContact = 'UPDATE `customercontacts` SET 
                        jobTitle="'.base64_decode($_Detail->JobTitle).'",
                        FirstName="'.base64_decode($_Detail->FirstName).'",
                        LastName="'.base64_decode($_Detail->LastName).'",
                        cell_reg="'.base64_decode($_Detail->cellNumber).'",
                        phone="'.base64_decode($_Detail->Phone).'",
                        email="'.base64_decode($_Detail->Email).'",
                        fax="'.base64_decode($_Detail->Fax).'"
                      WHERE id="'.$sub_row['id'].'"';
          $data = $this->connect->Execute($queryContact);
        }else{
          if($_Detail->FirstName != '' || $_Detail->LastName != '' || $_Detail->JobTitle != '' || $_Detail->Phone != '' || $_Detail->cellNumber != '' || $_Detail->Fax != '' || $_Detail->Email != ''){
             $queryContact = 'INSERT INTO `customercontacts`(
                          customerId,
                          CompanyID,
                          ListId,
                          FirstName,
                          LastName,
                          jobTitle,
                          Phone,
                          cell_reg,
                          fax,
                          email,
                          createdBy
                          ) values(
                            "'.$customerId.'",
                            "'.$_Detail->CompanyID.'",
                            "'.trim($_Detail->ListID).'",
                             "'.base64_decode($_Detail->FirstName).'",
                            "'.base64_decode($_Detail->LastName).'",
                            "'.base64_decode($_Detail->JobTitle).'",
                            "'.base64_decode($_Detail->Phone).'",
                            "'.base64_decode($_Detail->cellNumber).'",
                            "'.base64_decode($_Detail->Fax).'",
                            "'.base64_decode($_Detail->Email).'","1"             
                          )';
          }
          $data = $this->connect->Execute($queryContact);
        }   
      return true;
  }
  function insertSubContact($_SubDetail,$customerId){
    foreach ($_SubDetail as $key => $_SubDetailVal) 
    {
       $queryContact = 'INSERT INTO `customercontacts`(
                        customerId,
                        CompanyID,
                        ListId,
                        FirstName,
                        LastName,
                        jobTitle,
                        Phone,
                        cell_reg,
                        fax,
                        email,
                        createdBy
                        ) values(
                          "'.$customerId.'",
                          "'.$_SubDetailVal->CustomCompanyID.'",
                          "'.base64_decode($_SubDetailVal->CustomListID).'",
                           "'.base64_decode($_SubDetailVal->CustomFirstName).'",
                          "'.base64_decode($_SubDetailVal->CustomLastName).'",
                          "'.base64_decode($_SubDetailVal->CustomJobTitle).'",
                          "'.base64_decode($_SubDetailVal->CustomPhone).'",
                          "'.base64_decode($_SubDetailVal->CustomCellNumber).'",
                          "'.base64_decode($_SubDetailVal->CustomFax).'",
                          "'.base64_decode($_SubDetailVal->CustomEmail).'","1"             
                        )';
          $data = $this->connect->Execute($queryContact);
    }
      return true;
  }
  function customer(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post->Customer;
      $_SubDetail=@$post->CustomDetail;
      /*echo '<pre>_Detail';
      print_r($_Detail); print_r($_SubDetail); exit;*/
      $query="SELECT * FROM customermaster WHERE ListID='".$_Detail->ListID."' AND CompanyID='".$_Detail->CompanyID."'";
      
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $c_row=mysqli_fetch_assoc($data);
           $query = 'UPDATE `customermaster` SET 
                      Name="'.base64_decode($_Detail->Name).'",
                      FullName="'.base64_decode($_Detail->FullName).'",
                      IsActive="'.trim($_Detail->IsActive).'",
                      ClassName="'.base64_decode($_Detail->ClassName).'",
                      ParentListID="'.trim($_Detail->ParentListID).'",
                      ParentName="'.base64_decode($_Detail->ParentName).'",
                      CompanyName="'.base64_decode($_Detail->Name).'",
                      FirstName="'.base64_decode($_Detail->FirstName).'",
                      MiddleName="'.base64_decode($_Detail->MiddleName).'",
                      LastName="'.base64_decode($_Detail->LastName).'",
                      JobTitle="'.base64_decode($_Detail->JobTitle).'",
                      BillAddress1="'.base64_decode($_Detail->BillAddress1).'",
                      BillAddress2="'.base64_decode($_Detail->BillAddress2).'",
                      BillAddress3="'.base64_decode($_Detail->BillAddress3).'",
                      BillCity="'.base64_decode($_Detail->BillCity).'",
                      BillState="'.base64_decode($_Detail->BillState).'",
                      BillPostalCode="'.base64_decode($_Detail->BillPostalCode).'",
                      BillCountry="'.base64_decode($_Detail->BillCountry).'",
                      ShipAddress1="'.base64_decode($_Detail->ShipAddress1).'",
                      ShipAddress2="'.base64_decode($_Detail->ShipAddress2).'",
                      ShipAddress3="'.base64_decode($_Detail->ShipAddress3).'",
                      ShipCity="'.base64_decode($_Detail->ShipCity).'",
                      ShipState="'.base64_decode($_Detail->ShipState).'",
                      ShipPostalCode="'.base64_decode($_Detail->ShipPostalCode).'",
                      ShipCountry="'.base64_decode($_Detail->ShipCountry).'",
                      Phone="'.base64_decode($_Detail->Phone).'",
                      AltPhone="'.base64_decode($_Detail->AltPhone).'",
                      saleNumber="'.base64_decode($_Detail->cellNumber).'",
                      Fax="'.base64_decode($_Detail->Fax).'",
                      Email="'.base64_decode($_Detail->Email).'",
                      CC="'.base64_decode($_Detail->CC).'",
                      AltContact="'.base64_decode($_Detail->AltContact).'",
                      AccountNumber="'.base64_decode($_Detail->AccountNumber).'",
                      CompanyID="'.trim($_Detail->CompanyID).'",
                      CustomerTypeName="'.base64_decode($_Detail->CustomerTypeName).'",
                      TermName="'.base64_decode($_Detail->TermName).'",
                      SalesRepName="'.base64_decode($_Detail->SalesRepName).'",
                      Balance="'.trim($_Detail->Balance).'",
                      TotalBalance="'.trim($_Detail->TotalBalance).'",
                      SalesTaxCodeName="'.base64_decode($_Detail->SalesTaxCodeName).'",
                      SalesTaxCountry="'.base64_decode($_Detail->SalesTaxCountry).'",
                      Notes="'.base64_decode($_Detail->Notes).'",
                      MainPhone="'.base64_decode($_Detail->MainPhone).'",
                      MainEmail="'.base64_decode($_Detail->MainEmail).'",
                      PreferredPaymentMethodName="'.base64_decode($_Detail->PreferredPaymentMethodName).'",
                      JobStatus="'.base64_decode($_Detail->JobStatus).'",
                      CCEmail="'.base64_decode($_Detail->CCEmail).'",
                      PreferredDeliveryMethod="'.base64_decode($_Detail->PreferredDeliveryMethod).'",
                      IsSync="'.trim($_Detail->IsSync).'",
                      syncUpdateDate="'.Date('Y-m-d H:i:s').'" 
                    WHERE id="'.$c_row['id'].'"';
        $data = $this->connect->Execute($query);
        if($data){
          $this->insertMainContact($_Detail,$c_row['id']);
          if($_SubDetail)
            $this->updateSubContacts($_SubDetail,$c_row['id']);
          $arr[] = array('success' => 1, 'message' => "Customer updated Successfully", 'ID' =>$c_row['id']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Customer not updated","ID" => $c_row['id']);
        }
        
      }else{
         
        $IsActive = trim($_Detail->IsActive);
         $query = 'INSERT INTO `customermaster`(
                      ListID,
                      Name,
                      FullName,
                      IsActive,
                      ClassName,
                      ParentListID,
                      ParentName,
                      CompanyName,
                      FirstName,
                      MiddleName,
                      LastName,
                      JobTitle,
                      BillAddress1,
                      BillAddress2,
                      BillAddress3,
                      BillCity,
                      BillState,
                      BillPostalCode,
                      BillCountry,
                      ShipAddress1,
                      ShipAddress2,
                      ShipAddress3,
                      ShipCity,
                      ShipState,
                      ShipPostalCode,
                      ShipCountry,
                      Phone,
                      AltPhone,
                      saleNumber,
                      Fax,
                      Email,
                      CC,
                      AltContact,
                      AccountNumber,
                      CompanyID,
                      CustomerTypeName,
                      TermName,
                      SalesRepName,
                      Balance,
                      TotalBalance,
                      SalesTaxCodeName,
                      SalesTaxCountry,
                      Notes,
                      MainPhone,
                      MainEmail,
                      PreferredPaymentMethodName,
                      JobStatus,
                      CCEmail,
                      PreferredDeliveryMethod,
                      IsSync
                      ) values(
                        "'.$_Detail->ListID.'",
                        "'.base64_decode($_Detail->Name).'",
                        "'.base64_decode($_Detail->FullName).'",
                        "'.$IsActive.'",
                        "'.base64_decode($_Detail->ClassName).'",
                        "'.trim($_Detail->ParentListID).'",
                        "'.base64_decode($_Detail->ParentName).'",
                        "'.base64_decode($_Detail->Name).'",
                        "'.base64_decode($_Detail->FirstName).'",
                        "'.base64_decode($_Detail->MiddleName).'",
                        "'.base64_decode($_Detail->LastName).'",
                        "'.base64_decode($_Detail->JobTitle).'",
                        "'.base64_decode($_Detail->BillAddress1).'",
                        "'.base64_decode($_Detail->BillAddress2).'",
                        "'.base64_decode($_Detail->BillAddress3).'",
                        "'.base64_decode($_Detail->BillCity).'",
                        "'.base64_decode($_Detail->BillState).'",
                        "'.base64_decode($_Detail->BillPostalCode).'",
                        "'.base64_decode($_Detail->BillCountry).'",
                        "'.base64_decode($_Detail->ShipAddress1).'",
                        "'.base64_decode($_Detail->ShipAddress2).'",
                        "'.base64_decode($_Detail->ShipAddress3).'",
                        "'.base64_decode($_Detail->ShipCity).'",
                        "'.base64_decode($_Detail->ShipState).'",
                        "'.base64_decode($_Detail->ShipPostalCode).'",
                        "'.base64_decode($_Detail->ShipCountry).'",
                        "'.base64_decode($_Detail->Phone).'",
                        "'.base64_decode($_Detail->AltPhone).'",
                        "'.base64_decode($_Detail->cellNumber).'",
                        "'.base64_decode($_Detail->Fax).'",
                        "'.base64_decode($_Detail->Email).'",
                        "'.base64_decode($_Detail->CC).'",
                        "'.base64_decode($_Detail->AltContact).'",
                        "'.base64_decode($_Detail->AccountNumber).'",
                        "'.trim($_Detail->CompanyID).'",
                        "'.base64_decode($_Detail->CustomerTypeName).'",
                        "'.base64_decode($_Detail->TermName).'",
                        "'.base64_decode($_Detail->SalesRepName).'",
                        "'.trim($_Detail->Balance).'",
                        "'.trim($_Detail->TotalBalance).'",
                        "'.base64_decode($_Detail->SalesTaxCodeName).'",
                        "'.base64_decode($_Detail->SalesTaxCountry).'",
                        "'.base64_decode($_Detail->Notes).'",
                        "'.base64_decode($_Detail->MainPhone).'",
                        "'.base64_decode($_Detail->MainEmail).'",
                        "'.base64_decode($_Detail->PreferredPaymentMethodName).'",
                        "'.base64_decode($_Detail->JobStatus).'",
                        "'.base64_decode($_Detail->CCEmail).'",
                        "'.base64_decode($_Detail->PreferredDeliveryMethod).'",
                        "'.trim($_Detail->IsSync).'"                        
                      )';
        $data = $this->connect->Execute($query);
        $insertedId = $this->connect->getInsertedId();
        if($data){
          //main entry to customercontact
          $this->insertMainContact($_Detail,$insertedId);
          if($_SubDetail)
            $this->insertSubContact($_SubDetail,$insertedId);
          $arr[] = array('success' => 1, 'message' => "Customer Insert successfully", 'ListID' =>$_Detail->ListID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Customer not insert","ListID" => $_Detail->ListID);
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  
  function getInvoiceSync(){
    $post=file_get_contents('php://input');
    //if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail=$post[0];
     $query="SET SQL_BIG_SELECTS=1;";
     $data = $this->connect->Execute($query);
      $query="SELECT 
  i.*,cm.ListID ,
 cm.Name AS CustomerName1
FROM invoicemaster AS i  
INNER JOIN customermaster AS cm ON cm.id=i.CustomerListID 
Where (i.IsSync=0 or i.IsSync IS Null) AND i.Type='I'  and i.CompanyID=".$_Detail->CompanyId;
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
        while($rows=mysqli_fetch_assoc($data)){
            $inv_row[]=$rows;
        }
        $arr = $inv_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function invoice(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post->invoice;
      $invoiceLineDetail = $post->invoiceLineDetail;
      $customerId = $this->getCustomerId(trim($_Detail->CustomerListID),trim($_Detail->CompanyID));
      if($customerId == 0){
         $arr[] = array('success' => 0, 'message' => "Fail ! customer not found - skip","TxnLineId" => $_Detail->TxnID);
         header('Content-type: application/json');
         echo json_encode($arr);
         exit;
      }
      $query="SELECT id FROM invoicemaster WHERE TxnID='".$_Detail->TxnID."' AND companyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){ 
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `invoicemaster` SET 
                      CustomerListID="'.trim($customerId).'",
                      ClassName="'.base64_decode($_Detail->ClassName).'",
                      TxnDate="'.trim($_Detail->TxnDate).'",
                      RefNumber="'.base64_decode($_Detail->RefNumber).'",
                      BillAddress1="'.base64_decode($_Detail->BillAddress1).'",
                      BillAddress2="'.base64_decode($_Detail->BillAddress2).'",
                      BillAddress3="'.base64_decode($_Detail->BillAddress3).'",
                      BillCity="'.base64_decode($_Detail->BillCity).'",
                      BillState="'.base64_decode($_Detail->BillState).'",
                      BillPostalCode="'.base64_decode($_Detail->BillPostalCode).'",
                      BillCountry="'.base64_decode($_Detail->BillCountry).'",
                      ShipAddress1="'.base64_decode($_Detail->ShipAddress1).'",
                      ShipAddress2="'.base64_decode($_Detail->ShipAddress2).'",
                      ShipAddress3="'.base64_decode($_Detail->ShipAddress3).'",
                      ShipCity="'.base64_decode($_Detail->ShipCity).'",
                      ShipState="'.base64_decode($_Detail->ShipState).'",
                      ShipPostalCode="'.base64_decode($_Detail->ShipPostalCode).'",
                      ShipCountry="'.base64_decode($_Detail->ShipCountry).'",
                      PoNumber="'.base64_decode($_Detail->PoNumber).'",
                      TermName="'.base64_decode($_Detail->TermName).'",
                      DueDate="'.trim($_Detail->DueDate).'",
                      SalesRepName="'.base64_decode($_Detail->SalesRepName).'",
                      ShipDate="'.trim($_Detail->ShipDate).'",
                      ShipMethodName="'.base64_decode($_Detail->ShipMethodName).'",
                      SubTotal="'.trim($_Detail->SubTotal).'",
                      SalesTaxPercentage="'.trim($_Detail->SalesTaxPercentage).'",
                      SalesTaxTotal="'.trim($_Detail->SalesTaxTotal).'",
                      BalanceRemining="'.trim($_Detail->BalanceRemining).'",
                      Memo="'.base64_decode($_Detail->Memo).'",
                      IsPaid="'.trim($_Detail->IsPaid).'",
                      TotalAmt="'.trim($_Detail->TotalAmt).'",
                      CompanyID="'.trim($_Detail->CompanyID).'",
                      ARAccountName="'.base64_decode($_Detail->ARAccountName).'",
                      TemplateName="'.base64_decode($_Detail->TemplateName).'",
                      salestaxitem="'.base64_decode($_Detail->salestaxitem).'",
                      CustomerSalesTaxCodeName="'.base64_decode($_Detail->CustomerSalesTaxCodeName).'",
                      IsSync="'.trim($_Detail->IsSync).'",
                      Type="'.trim($_Detail->Type).'"
                    WHERE id="'.trim($p_row['id']).'"';
        $data = $this->connect->Execute($query);
        if($data){ 
           //delete all lineitem
            $query="DELETE FROM `invocielineitemsmaster` WHERE invoice_id='".trim($p_row['id'])."'";
            $this->connect->Execute($query);

           foreach ($invoiceLineDetail as $key => $value) 
           {
            $itemId = $this->getItemId(trim($value->ItemListID),trim($_Detail->CompanyID));
            //start Invoice Line
            if($value->TxnLineId != "")
            {
                $query = 'INSERT INTO `invocielineitemsmaster`(
                              invoice_id,
                              TxnLineId,
                              TxnID,
                              ItemListID,
                              Description,
                              Quantity,
                              Rate,
                              ClassName,
                              Amount,
                              SalesTaxCode,
                              IsSync,
                    CompanyID
                              ) values(
                                "'.trim($p_row['id']).'",
                                "'.$value->TxnLineId.'",
                                "'.trim($value->TxnID).'",
                                "'.trim($itemId).'",
                                "'.base64_decode($value->Description).'",
                                "'.trim($value->Quantity).'",
                                "'.trim($value->Rate).'",
                                "'.base64_decode($value->ClassName).'",
                                "'.trim($value->Amount).'",
                                "'.base64_decode($value->SalesTaxCode).'",
                                "'.base64_decode($value->IsSync).'",
                     "'.trim($value->CompanyID).'"          
                              )';
                $data = $this->connect->Execute($query);
                if($data){
                  //$arr[] = array('success' => 1, 'message' => "Invoice Line insert successfully", 'TxnLineId' =>$value->TxnLineId);
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Invoice Line not insert","TxnLineId" => $value->TxnLineId);
                }
              }else{
                $arr[] = array('success' => 0, 'message' => "Error: Invoice Line TxnLineId is empty!!!");
              }
              //End Invoice Line
          } //End ForEach
          
          $arr[] = array('success' => 1, 'message' => "Invoice Update successfully", 'InvoiceId' =>$p_row['id']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Invoice not updated","InvoiceId" => $p_row['id']);
        }
        //End Update
      }else{
        //Start Insert
        $query = 'INSERT INTO `invoicemaster`(
                      TxnID,
                      CustomerListID,
                      ClassName,
                      TxnDate,
                      RefNumber,
                      BillAddress1,
                      BillAddress2,
                      BillAddress3,
                      BillCity,
                      BillState,
                      BillPostalCode,
                      BillCountry,
                      ShipAddress1,
                      ShipAddress2,
                      ShipAddress3,
                      ShipCity,
                      ShipState,
                      ShipPostalCode,
                      ShipCountry,
                      PoNumber,
                      TermName,
                      DueDate,
                      SalesRepName,
                      ShipDate,
                      ShipMethodName,
                      SubTotal,
                      SalesTaxPercentage,
                      SalesTaxTotal,
                      BalanceRemining,
                      Memo,
                      IsPaid,
                      TotalAmt,
                      CompanyID,
                      ARAccountName,
                      TemplateName,
                      CustomerSalesTaxCodeName,
                      IsSync,
                      salestaxitem,
                      Type
                      ) values(
                        "'.$_Detail->TxnID.'",
                        "'.trim($customerId).'",
                        "'.base64_decode($_Detail->ClassName).'",
                        "'.trim($_Detail->TxnDate).'",
                        "'.base64_decode($_Detail->RefNumber).'",
                        "'.base64_decode($_Detail->BillAddress1).'",
                        "'.base64_decode($_Detail->BillAddress2).'",
                        "'.base64_decode($_Detail->BillAddress3).'",
                        "'.base64_decode($_Detail->BillCity).'",
                        "'.base64_decode($_Detail->BillState).'",
                        "'.base64_decode($_Detail->BillPostalCode).'",
                        "'.base64_decode($_Detail->BillCountry).'",
                        "'.base64_decode($_Detail->ShipAddress1).'",
                        "'.base64_decode($_Detail->ShipAddress2).'",
                        "'.base64_decode($_Detail->ShipAddress3).'",
                        "'.base64_decode($_Detail->ShipCity).'",
                        "'.base64_decode($_Detail->ShipState).'",
                        "'.base64_decode($_Detail->ShipPostalCode).'",
                        "'.base64_decode($_Detail->ShipCountry).'",
                        "'.base64_decode($_Detail->PoNumber).'",
                        "'.base64_decode($_Detail->TermName).'",
                        "'.trim($_Detail->DueDate).'",
                        "'.base64_decode($_Detail->SalesRepName).'",
                        "'.trim($_Detail->ShipDate).'",
                        "'.base64_decode($_Detail->ShipMethodName).'",
                        "'.trim($_Detail->SubTotal).'",
                        "'.trim($_Detail->SalesTaxPercentage).'",
                        "'.trim($_Detail->SalesTaxTotal).'",
                        "'.trim($_Detail->BalanceRemining).'",
                        "'.base64_decode($_Detail->Memo).'",
                        "'.trim($_Detail->IsPaid).'",
                        "'.trim($_Detail->TotalAmt).'",
                        "'.trim($_Detail->CompanyID).'",
                        "'.base64_decode($_Detail->ARAccountName).'",
                        "'.base64_decode($_Detail->TemplateName).'",
                        "'.base64_decode($_Detail->CustomerSalesTaxCodeName).'",
                        "'.trim($_Detail->IsSync).'",
                        "'.base64_decode($_Detail->salestaxitem).'",
                        "'.trim($_Detail->Type).'"
                      )';
        $data = $this->connect->Execute($query);
        $insertedId = $this->connect->getInsertedId();
        if($insertedId>0){
          foreach ($invoiceLineDetail as $key => $value) 
          {
            $itemId = $this->getItemId(trim($value->ItemListID),trim($_Detail->CompanyID));
            //start Invoice Line
            if($value->TxnLineId != "")
            {
                $query = 'INSERT INTO `invocielineitemsmaster`(
                              invoice_id,
                              TxnLineId,
                              TxnID,
                              ItemListID,
                              Description,
                              Quantity,
                              Rate,
                              ClassName,
                              Amount,
                              SalesTaxCode,
                              IsSync,
                    CompanyID
                              ) values(
                                "'.$insertedId.'",
                                "'.$value->TxnLineId.'",
                                "'.trim($value->TxnID).'",
                                "'.trim($itemId).'",
                                "'.base64_decode($value->Description).'",
                                "'.trim($value->Quantity).'",
                                "'.trim($value->Rate).'",
                                "'.base64_decode($value->ClassName).'",
                                "'.trim($value->Amount).'",
                                "'.base64_decode($value->SalesTaxCode).'",
                                "'.base64_decode($value->IsSync).'",
                     "'.trim($value->CompanyID).'"          
                              )';
                $data = $this->connect->Execute($query);
                if($data){
                  //$arr[] = array('success' => 1, 'message' => "Invoice Line insert successfully", 'TxnLineId' =>$value->TxnLineId);
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Invoice Line not insert","TxnLineId" => $value->TxnLineId);
                }
              }else{
                $arr[] = array('success' => 0, 'message' => "Error: Invoice Line TxnLineId is empty!!!");
              }
              //End Invoice Line
          } //End ForEach
          $arr[] = array('success' => 1, 'message' => "Invoice insert successfully", 'TxnID' =>$_Detail->TxnID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Invoice not insert","TxnID" => $_Detail->TxnID);
        }
        //End Insert
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
   function inActiveInvoice(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post->invoice;
      $invoiceLineDetail = $post->invoiceLineDetail;
      
      if(@$_Detail->customerName != ''){
        $customerId = $this->getCustomerName(base64_decode(@$_Detail->customerName),trim(@$_Detail->CompanyID));  
      }else{
        $customerId = 0;
      }
      

      if($customerId == 0){
         $arr[] = array('success' => 0, 'message' => "Fail ! customer not found - skip","TxnLineId" => $_Detail->TxnID);
         header('Content-type: application/json');
         echo json_encode($arr);
         exit;
      }
      $query="SELECT id FROM invoicemaster WHERE TxnID='".$_Detail->TxnID."' AND companyID='".$_Detail->CompanyID."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){ 
          $p_row=mysqli_fetch_assoc($data);
          $query = 'UPDATE `invoicemaster` SET 
                      CustomerListID="'.trim($customerId).'",
                      ClassName="'.base64_decode($_Detail->ClassName).'",
                      TxnDate="'.trim($_Detail->TxnDate).'",
                      RefNumber="'.base64_decode($_Detail->RefNumber).'",
                      BillAddress1="'.base64_decode($_Detail->BillAddress1).'",
                      BillAddress2="'.base64_decode($_Detail->BillAddress2).'",
                      BillAddress3="'.base64_decode($_Detail->BillAddress3).'",
                      BillCity="'.base64_decode($_Detail->BillCity).'",
                      BillState="'.base64_decode($_Detail->BillState).'",
                      BillPostalCode="'.base64_decode($_Detail->BillPostalCode).'",
                      BillCountry="'.base64_decode($_Detail->BillCountry).'",
                      ShipAddress1="'.base64_decode($_Detail->ShipAddress1).'",
                      ShipAddress2="'.base64_decode($_Detail->ShipAddress2).'",
                      ShipAddress3="'.base64_decode($_Detail->ShipAddress3).'",
                      ShipCity="'.base64_decode($_Detail->ShipCity).'",
                      ShipState="'.base64_decode($_Detail->ShipState).'",
                      ShipPostalCode="'.base64_decode($_Detail->ShipPostalCode).'",
                      ShipCountry="'.base64_decode($_Detail->ShipCountry).'",
                      PoNumber="'.base64_decode($_Detail->PoNumber).'",
                      TermName="'.base64_decode($_Detail->TermName).'",
                      DueDate="'.trim($_Detail->DueDate).'",
                      SalesRepName="'.base64_decode($_Detail->SalesRepName).'",
                      ShipDate="'.trim($_Detail->ShipDate).'",
                      ShipMethodName="'.base64_decode($_Detail->ShipMethodName).'",
                      SubTotal="'.trim($_Detail->SubTotal).'",
                      SalesTaxPercentage="'.trim($_Detail->SalesTaxPercentage).'",
                      SalesTaxTotal="'.trim($_Detail->SalesTaxTotal).'",
                      BalanceRemining="'.trim($_Detail->BalanceRemining).'",
                      Memo="'.base64_decode($_Detail->Memo).'",
                      IsPaid="'.trim($_Detail->IsPaid).'",
                      TotalAmt="'.trim($_Detail->TotalAmt).'",
                      CompanyID="'.trim($_Detail->CompanyID).'",
                      ARAccountName="'.base64_decode($_Detail->ARAccountName).'",
                      TemplateName="'.base64_decode($_Detail->TemplateName).'",
                      salestaxitem="'.base64_decode($_Detail->salestaxitem).'",
                      CustomerSalesTaxCodeName="'.base64_decode($_Detail->CustomerSalesTaxCodeName).'",
                      IsSync="'.trim($_Detail->IsSync).'",
                      Type="'.trim($_Detail->Type).'",
                      isOld = "1"
                    WHERE id="'.trim($p_row['id']).'"';
        $data = $this->connect->Execute($query);
        if($data){ 
           //delete all lineitem
            $query="DELETE FROM `invocielineitemsmaster` WHERE invoice_id='".trim($p_row['id'])."'";
            $this->connect->Execute($query);

           foreach ($invoiceLineDetail as $key => $value) 
           {
            $itemId = $this->getItemName(trim($value->itemName),trim($_Detail->CompanyID));
            //start Invoice Line
            if($value->TxnLineId != "")
            {
                $query = 'INSERT INTO `invocielineitemsmaster`(
                              invoice_id,
                              TxnLineId,
                              TxnID,
                              ItemListID,
                              Description,
                              Quantity,
                              Rate,
                              ClassName,
                              Amount,
                              SalesTaxCode,
                              IsSync,
                    CompanyID
                              ) values(
                                "'.trim($p_row['id']).'",
                                "'.$value->TxnLineId.'",
                                "'.trim($value->TxnID).'",
                                "'.trim($itemId).'",
                                "'.base64_decode($value->Description).'",
                                "'.trim($value->Quantity).'",
                                "'.trim($value->Rate).'",
                                "'.base64_decode($value->ClassName).'",
                                "'.trim($value->Amount).'",
                                "'.base64_decode($value->SalesTaxCode).'",
                                "'.base64_decode($value->IsSync).'",
                     "'.trim($value->CompanyID).'"          
                              )';
                $data = $this->connect->Execute($query);
                if($data){
                  //$arr[] = array('success' => 1, 'message' => "Invoice Line insert successfully", 'TxnLineId' =>$value->TxnLineId);
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Invoice Line not insert","TxnLineId" => $value->TxnLineId);
                }
              }else{
                $arr[] = array('success' => 0, 'message' => "Error: Invoice Line TxnLineId is empty!!!");
              }
              //End Invoice Line
          } //End ForEach
          $arr[] = array('success' => 1, 'message' => "Invoice Update successfully", 'InvoiceId' =>$p_row['id']);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Invoice not updated","InvoiceId" => $p_row['id']);
        }
        //End Update
      }else{
        //Start Insert
        $query = 'INSERT INTO `invoicemaster`(
                      TxnID,
                      CustomerListID,
                      ClassName,
                      TxnDate,
                      RefNumber,
                      BillAddress1,
                      BillAddress2,
                      BillAddress3,
                      BillCity,
                      BillState,
                      BillPostalCode,
                      BillCountry,
                      ShipAddress1,
                      ShipAddress2,
                      ShipAddress3,
                      ShipCity,
                      ShipState,
                      ShipPostalCode,
                      ShipCountry,
                      PoNumber,
                      TermName,
                      DueDate,
                      SalesRepName,
                      ShipDate,
                      ShipMethodName,
                      SubTotal,
                      SalesTaxPercentage,
                      SalesTaxTotal,
                      BalanceRemining,
                      Memo,
                      IsPaid,
                      TotalAmt,
                      CompanyID,
                      ARAccountName,
                      TemplateName,
                      CustomerSalesTaxCodeName,
                      IsSync,
                      isOld,
                      salestaxitem,
                      Type
                      ) values(
                        "'.$_Detail->TxnID.'",
                        "'.trim($customerId).'",
                        "'.base64_decode($_Detail->ClassName).'",
                        "'.trim($_Detail->TxnDate).'",
                        "'.base64_decode($_Detail->RefNumber).'",
                        "'.base64_decode($_Detail->BillAddress1).'",
                        "'.base64_decode($_Detail->BillAddress2).'",
                        "'.base64_decode($_Detail->BillAddress3).'",
                        "'.base64_decode($_Detail->BillCity).'",
                        "'.base64_decode($_Detail->BillState).'",
                        "'.base64_decode($_Detail->BillPostalCode).'",
                        "'.base64_decode($_Detail->BillCountry).'",
                        "'.base64_decode($_Detail->ShipAddress1).'",
                        "'.base64_decode($_Detail->ShipAddress2).'",
                        "'.base64_decode($_Detail->ShipAddress3).'",
                        "'.base64_decode($_Detail->ShipCity).'",
                        "'.base64_decode($_Detail->ShipState).'",
                        "'.base64_decode($_Detail->ShipPostalCode).'",
                        "'.base64_decode($_Detail->ShipCountry).'",
                        "'.base64_decode($_Detail->PoNumber).'",
                        "'.base64_decode($_Detail->TermName).'",
                        "'.trim($_Detail->DueDate).'",
                        "'.base64_decode($_Detail->SalesRepName).'",
                        "'.trim($_Detail->ShipDate).'",
                        "'.base64_decode($_Detail->ShipMethodName).'",
                        "'.trim($_Detail->SubTotal).'",
                        "'.trim($_Detail->SalesTaxPercentage).'",
                        "'.trim($_Detail->SalesTaxTotal).'",
                        "'.trim($_Detail->BalanceRemining).'",
                        "'.base64_decode($_Detail->Memo).'",
                        "'.trim($_Detail->IsPaid).'",
                        "'.trim($_Detail->TotalAmt).'",
                        "'.trim($_Detail->CompanyID).'",
                        "'.base64_decode($_Detail->ARAccountName).'",
                        "'.base64_decode($_Detail->TemplateName).'",
                        "'.base64_decode($_Detail->CustomerSalesTaxCodeName).'",
                        "'.trim($_Detail->IsSync).'",
                        "1",
                        "'.base64_decode($_Detail->salestaxitem).'",
                        "'.trim($_Detail->Type).'"
                      )';
        $data = $this->connect->Execute($query);
        $insertedId = $this->connect->getInsertedId();
        if($insertedId>0){
          foreach ($invoiceLineDetail as $key => $value) 
          {
            $itemId = $this->getItemName(trim($value->itemName),trim($_Detail->CompanyID));
            //start Invoice Line
            if($value->TxnLineId != "")
            {
                $query = 'INSERT INTO `invocielineitemsmaster`(
                              invoice_id,
                              TxnLineId,
                              TxnID,
                              ItemListID,
                              Description,
                              Quantity,
                              Rate,
                              ClassName,
                              Amount,
                              SalesTaxCode,
                              IsSync,
                    CompanyID
                              ) values(
                                "'.$insertedId.'",
                                "'.$value->TxnLineId.'",
                                "'.trim($value->TxnID).'",
                                "'.trim($itemId).'",
                                "'.base64_decode($value->Description).'",
                                "'.trim($value->Quantity).'",
                                "'.trim($value->Rate).'",
                                "'.base64_decode($value->ClassName).'",
                                "'.trim($value->Amount).'",
                                "'.base64_decode($value->SalesTaxCode).'",
                                "'.base64_decode($value->IsSync).'",
                     "'.trim($value->CompanyID).'"          
                              )';
                $data = $this->connect->Execute($query);
                if($data){
                  //$arr[] = array('success' => 1, 'message' => "Invoice Line insert successfully", 'TxnLineId' =>$value->TxnLineId);
                }else{
                  $arr[] = array('success' => 0, 'message' => "Fail ! Invoice Line not insert","TxnLineId" => $value->TxnLineId);
                }
              }else{
                $arr[] = array('success' => 0, 'message' => "Error: Invoice Line TxnLineId is empty!!!");
              }
              //End Invoice Line
          } //End ForEach
          $arr[] = array('success' => 1, 'message' => "Invoice insert successfully", 'TxnID' =>$_Detail->TxnID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Invoice not insert","TxnID" => $_Detail->TxnID);
        }
        //End Insert
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function getCustomer(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query="SELECT * FROM customermaster WHERE id='".$post[0]['ID']."' AND CompanyID='".$post[0]['CompanyID']."'";
      
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $c_row=mysqli_fetch_assoc($data);
          $arr['Customer'] = $c_row;
          $subquery="SELECT * FROM customercontacts WHERE customerId='".$c_row['id']."' AND CompanyID='".$post[0]['CompanyID']."'";
          $subdata = $this->connect->Execute($subquery);
          if($this->connect->getAffectedRow() > 0){
            while($rows=mysqli_fetch_assoc($subdata)){
              $p_row[]=$rows;
            }
            $arr['CustomDetail'] = $p_row;
          }
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function upCustomerIsSync(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!='')
    {
      $post=json_decode($post);
      $_Detail=$post[0];
      if($_Detail->ListID != ""){
        $query = 'UPDATE `customermaster` SET      
                      IsSync="'.trim($_Detail->IsSync).'",
                      ListID="'.trim($_Detail->ListID).'" 
                    WHERE id="'.$_Detail->ID.'"';
        $data = $this->connect->Execute($query);
        if($data){
          $arr[] = array('success' => 1, 'message' => "Customer updated Successfully", 'ListID' =>$_Detail->ListID);
        }else{
          $arr[] = array('success' => 0, 'message' => "Fail ! Customer not updated","ListID" => $_Detail->ListID);
        }
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Customer id is empty!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }

    echo json_encode($arr);
  }
  function getItems(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query_set="SET SQL_BIG_SELECTS=1;";
      $this->connect->Execute($query_set);
      $query="SELECT * FROM `itemmaster` WHERE Id='".$post[0]['ID']."' AND CompanyID='".$post[0]['CompanyID']."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $arr[] = $p_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function updateInvoice(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post[0];
      $query = 'UPDATE `invoicemaster` SET 
                      IsSync="1",
                      TxnID="'.trim($_Detail->TxnID).'"
                    WHERE id="'.trim($_Detail->ID).'"';
      $data = $this->connect->Execute($query);
      if($data){
        $arr[] = array('success' => 1, 'message' => "Invoice updated Successfully", 'ID' =>$_Detail->ID);
      }else{
        $arr[] = array('success' => 0, 'message' => "Fail ! Invoice not updated","ID" => $_Detail->ID);
      }
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function updateItem(){ 
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $_Detail = $post[0];
      $query = 'UPDATE `itemmaster` SET 
                      IsSync="1",
                      ListID="'.trim($_Detail->ListID).'"
                    WHERE Id="'.trim($_Detail->ID).'"';
          $data = $this->connect->Execute($query);
          if($data){
            $arr[] = array('success' => 1, 'message' => "Invoice updated Successfully", 'ID' =>$_Detail->ID);
          }else{
            $arr[] = array('success' => 0, 'message' => "Fail ! Invoice not updated","ID" => $_Detail->ID);
          }
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function getInvoiceLineSync(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query="SELECT il.*,itm.ListID,itm.Name as ItemName1 FROM invocielineitemsmaster AS il  INNER JOIN itemmaster AS itm ON itm.id=il.ItemListID WHERE il.invoice_id='".$post[0]['id']."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          while($rows=mysqli_fetch_assoc($data)){
            $p_row[]=$rows;
          }
          $arr = $p_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function getHistory(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query="SELECT * FROM history WHERE DATE(CreatedDate)='".$post[0]['CreatedDate']."' AND CompanyID='".$post[0]['CompanyID']."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          while($rows=mysqli_fetch_assoc($data)){
            $p_row[]=$rows;
          }
          $arr = $p_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function getCompanyDetail(){
   $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query="SELECT * FROM companymaster WHERE MacID='".base64_decode($post[0]['MacID'])."'"; 
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          $arr[] = $p_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function getCustomerId($listId,$cId){
       $query="SELECT id FROM customermaster WHERE ListID='".$listId."' AND CompanyID = ".$cId;
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          return $p_row['id'];
      }else{
         return 0;
      }
  }
    function getCustomerName($name,$cId){
$query='SELECT id FROM customermaster WHERE Name="'.$name.'" AND CompanyID = '.$cId;
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          return $p_row['id'];
      }else{
         return 0;
      }
  }
  function getItemId($listId,$cId){
       $query="SELECT Id FROM itemmaster WHERE ListID='".$listId."' AND CompanyID = ".$cId;
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          return $p_row['Id'];
      }else{
         return 0;
      }
  }
  function getItemName($Name,$cId){
       $query='SELECT Id FROM itemmaster WHERE Name="'.$Name.'" AND CompanyID = '.$cId;
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $p_row=mysqli_fetch_assoc($data);
          return $p_row['Id'];
      }else{
         return 0;
      }
  }
  function updateCustomerSaledate(){
     $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
          $query = 'UPDATE customermaster SET customermaster.last_sale_date = (select max(inv.TxnDate) from invoicemaster as inv where inv.CustomerListID = customermaster.id) where CompanyID = '.$post[0]['CompanyID'];
          $res = $this->connect->Execute($query);
          if($res){
            $arr[] = array('success' => 1, 'message' => "customermaster updated Successfully");
          }else{
            $arr[] = array('success' => 0, 'message' => "Fail ! customermaster not updated");
          }  
     }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);   
  }
  //**Common Function**//
  function Auth($AppID, $Username, $Password){
    $query="SELECT ID FROM qbconnector WHERE Username = '{$Username}' AND Password = '{$Password}' AND AppID = '{$AppID}'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
        return true;
      }else{
        $arr[] = array('success' => 0, 'message' => "Invalid credentials!!!");
        echo json_encode($arr);exit;
      }
  }
  function upCustomerContactListId(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!='')
    {
      $post=json_decode($post);
      $_Detail=$post->Customer;
      $_SubDetail=@$post->CustomDetail;
      if($_Detail->ListID != "")
      {
        $query = 'UPDATE `customermaster` SET      
                      IsSync="'.trim($_Detail->IsSync).'",
                      ListID="'.trim($_Detail->ListID).'"
                    WHERE id="'.$_Detail->ID.'"';
        $data = $this->connect->Execute($query);
        $queryContact = 'UPDATE `customercontacts` SET 
                          ListId="'.$_Detail->ListID.'"
                      WHERE jobTitle="'.base64_decode($_Detail->JobTitle).'" AND 
              FirstName="'.base64_decode($_Detail->FirstName).'" AND 
              LastName="'.base64_decode($_Detail->LastName).'" AND 
              customerId="'.trim($_Detail->ID).'"
              AND CompanyID="'.$_Detail->CompanyID.'"';
        $data = $this->connect->Execute($queryContact);
        
        if($data){
          $arr[] = array('success' => 1, 'message' => "customerMailcontacts updated Successfully", 'ListID' =>$_Detail->ListID);
        }else{
          $queryContact = 'UPDATE `customercontacts` SET `ListId`="'.trim($_Detail->ListID).'" where `customerId`="'.trim($_Detail->ID).'" AND `createdBy`="1"  limit 1 ';
            $data = $this->connect->Execute($queryContact);
            if($data){
              $arr[] = array('success' => 1, 'message' => "customerMailcontacts updated Successfully", 'ListID' =>$_Detail->ListID);
            }else{
              $arr[] = array('success' => 0, 'message' => "Fail ! Customer not updated","ListID" => $_Detail->ListID);
            }
        }
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Customer id is empty!!!");
      }
      if($_SubDetail){
        foreach ($_SubDetail as $key => $_SubDetailvalue) 
        {
          $queryContact='SELECT id FROM customercontacts WHERE 
              jobTitle="'.base64_decode($_SubDetailvalue->CustomJobTitle).'" AND 
              FirstName="'.base64_decode($_SubDetailvalue->CustomFirstName).'" AND 
              LastName="'.base64_decode($_SubDetailvalue->CustomLastName).'" AND 
              cell_reg="'.base64_decode($_SubDetailvalue->CustomCellNumber).'" AND 
              phone="'.base64_decode($_SubDetailvalue->CustomPhone).'" AND 
              customerId="'.trim($_Detail->ID).'"
              AND CompanyID="'.$_SubDetailvalue->CustomCompanyID.'" limit 1';        
          $data = $this->connect->Execute($queryContact);
          if($this->connect->getAffectedRow() > 0){
              $sub_row=mysqli_fetch_assoc($data);
               $queryContact = 'UPDATE `customercontacts` SET 
                          ListId="'.base64_decode($_SubDetailvalue->CustomListID).'"
                        WHERE id="'.$sub_row['id'].'"';
            $data = $this->connect->Execute($queryContact);
          }else{

          }
        }
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }

    echo json_encode($arr);
  }
   function getInvoiceDeleted(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post);
      $query_set="SET SQL_BIG_SELECTS=1;";
      $this->connect->Execute($query_set);
      $query="SELECT * FROM `invoicemaster` WHERE isDelete='1' AND Type='I' AND CompanyID='".$post[0]->CompanyId."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
        while($rows=mysqli_fetch_assoc($data)){
            $inv_row[]=$rows;
        }
        $arr = $inv_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function deleteInvoice(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query_set="SET SQL_BIG_SELECTS=1;";
      $this->connect->Execute($query_set);
      $query="DELETE c.*, sb.*
      FROM invoicemaster c
      LEFT JOIN invocielineitemsmaster sb ON c.id = sb.invoice_id
      WHERE c.id ='".$post[0]['id']."'";
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $arr[] = array('success' => 0, 'message' => "Success: Delete successfully!!!");
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: something went wrong!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function deleteCustomer(){

    $post=file_get_contents('php://input');
    
    //$post = array(array('ListID'=>"80000143-1427138979",'CompanyID'=>"1"));
    /*echo '<pre>';
    print_r($post);
    exit;*/
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      $query='select id from customermaster where ListID = "'.$post[0]['ListID'].'" AND CompanyID = "'.$post[0]['CompanyID'].'"';
      
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
           $p_row=mysqli_fetch_assoc($data);
           if($p_row['id'] > 0){
               $query = 'UPDATE `customermaster` SET 
                      isDelete="1"
                    WHERE id="'.$p_row['id'].'"';
              $data = $this->connect->Execute($query);
            $arr[] = array('success' => 0, 'message' => "Success: Delete successfully!!!");
           }else{
            $arr[] = array('success' => 0, 'message' => "Success: ListID Not Found!!!");
           }
          
      }else{
        $arr[] = array('success' => 0, 'message' => "Success: ListID Not Found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
   
   function deleteItem(){

    $post=file_get_contents('php://input');
    //$post = array(array('ListID'=>"800000E3-1501600649",'CompanyID'=>"1",'Type'=>"ItemInventory"));
    /*echo '<pre>';
    print_r($post);
    exit;*/
    if(isset($post) && $post!=''){
     $post=json_decode($post,true);
      if(@$post[0]['Type'] == "ItemInventory"){
         $query='select Id as ID from itemmaster where ListID = "'.$post[0]['ListID'].'" AND CompanyID = "'.$post[0]['CompanyID'].'"';
         $update_query = 'UPDATE `itemmaster` SET 
                      isDelete="1"
                    WHERE id=';
      }else if(@$post[0]['Type'] == "ItemSalesTax"){
        $query='select ID as ID from salestaxitemmaster where ListID = "'.$post[0]['ListID'].'" AND CompanyID = "'.$post[0]['CompanyID'].'"';
         $update_query = 'UPDATE `salestaxitemmaster` SET 
                      isDelete="1"
                    WHERE ID=';
      }else if(@$post[0]['Type'] == "ItemSalesTaxGroup"){
        $query='select id as ID from salestaxgroup where ListId = "'.$post[0]['ListID'].'" AND CompanyID = "'.$post[0]['CompanyID'].'"';
         $update_query = 'UPDATE `salestaxgroup` SET 
                      isDelete="1"
                    WHERE id=';
      }else if(@$post[0]['Type'] == "SalesTaxCode"){
        $query='select ID as ID from salestaxcode where ListID = "'.$post[0]['ListID'].'" AND CompanyID = "'.$post[0]['CompanyID'].'"';
         $update_query = 'UPDATE `salestaxcode` SET 
                      isDelete="1"
                    WHERE ID=';
      }
      
     
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
           $p_row=mysqli_fetch_assoc($data);
           if($p_row['ID'] > 0){
              $query = $update_query.'"'.$p_row['ID'].'"'; 
              $data = $this->connect->Execute($query);
            $arr[] = array('success' => 0, 'message' => "Success: Delete successfully!!!");
           }else{
            $arr[] = array('success' => 0, 'message' => "Success: ListID Not Found!!!");
           }
          
      }else{
         $arr[] = array('success' => 0, 'message' => "Success: ListID Not Found!!!");
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
   function getLastModifiedItem(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
      
       $query="SELECT * FROM `itemmaster` WHERE `lastModifiedDate` >= (SELECT fromDB FROM qbupdate_history WHERE Type='item' AND `CompanyID` = '".$post[0]['CompanyID']."') AND `CompanyID` = '".$post[0]['CompanyID']."'"; 
        $data = $this->connect->Execute($query);
        if($this->connect->getAffectedRow() > 0){
            while($rows=mysqli_fetch_assoc($data)){
              $p_row[]=$rows;
            }
            $arr = $p_row;
        }else{
          $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
        }

    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }

  function getLastModifiedCustomer(){
    $post=file_get_contents('php://input');
    //$post = json_encode(array(array('CompanyID'=>"1")));
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
  
      $query="SELECT * FROM `customermaster` WHERE `lastModifiedDate` >= (SELECT fromDB FROM qbupdate_history WHERE Type='customer' AND `CompanyID` = '".$post[0]['CompanyID']."')  AND `CompanyID` = '".$post[0]['CompanyID']."'"; 
      $data = $this->connect->Execute($query);
      if($this->connect->getAffectedRow() > 0){
          $i=0;
          while($rows=mysqli_fetch_assoc($data)){
            $p_row[$i]=$rows;

            $query="SELECT * FROM `customercontacts` WHERE `customerId` = '".$rows['id']."' AND `CompanyID` = '".$post[0]['CompanyID']."'"; 
            $data = $this->connect->Execute($query);
            if($this->connect->getAffectedRow() > 0){
                while($rows=mysqli_fetch_assoc($data)){
                  $p_row[$i]['subcontact'][]=$rows;
                }
            }
            $i++;
          }
          $arr = $p_row;
      }else{
        $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
      }


    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }


  function qbupdate_history()
  {
    $post=file_get_contents('php://input');
    if(isset($post) && $post!='')
    {
      $post=json_decode($post);
      $_Detail=$post[0];
      if(trim($_Detail->Field) == "fromQB"){

        $query = 'UPDATE `qbupdate_history` SET 
                      fromQB = "'.trim($_Detail->DateTime).'"
                    WHERE Type="'.trim($_Detail->Type).'" AND CompanyID="'.trim($_Detail->CompanyID).'"';
      }else{

        $query = 'UPDATE `qbupdate_history` SET 
                      fromDB = "'.trim($_Detail->DateTime).'"
                    WHERE Type="'.trim($_Detail->Type).'" AND CompanyID="'.trim($_Detail->CompanyID).'"';
      }
      $data = $this->connect->Execute($query);
      if($data){
        $arr[] = array('success' => 1, 'message' => "qbupdate_history updated Successfully", 'Type' =>$_Detail->Type);
      }else{
        $arr[] = array('success' => 0, 'message' => "Fail ! qbupdate_history not updated","Type" => $_Detail->Type);
      }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }

  function get_qbhistory(){
    $post=file_get_contents('php://input');
    if(isset($post) && $post!=''){
      $post=json_decode($post,true);
        $query="SELECT fromQB FROM qbupdate_history WHERE CompanyID  ='".$post[0]['CompanyID']."' AND Type='".$post[0]['Type']."'"; 
        $data = $this->connect->Execute($query);
        if($this->connect->getAffectedRow() > 0){
            while($rows=mysqli_fetch_assoc($data)){
              $p_row=$rows;
            }
            $arr = $p_row;
        }else{
          $arr[] = array('success' => 0, 'message' => "Error: Data not found!!!");
        }
    }else{
      $arr[] = array('success' => 0, 'message' => "Error: Post data empty!!!");
    }
    header('Content-type: application/json');
    echo json_encode($arr);
  }
  function closeConnection(){
    //mysqli_close($this->connect);
  }
}
?>