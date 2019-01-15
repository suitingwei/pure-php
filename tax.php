<?php

class TaxCalculator
{
    const BASE_TAX_MONEY = 5000;
    const TAX_Levels     = [
        [
            'lowLevel'    => 0,
            'upLevel'     => '36000',
            'taxPercent'  => 0.03,
            'quickNumber' => 0,
        ],
        [
            'lowLevel'    => '36000',
            'upLevel'     => '144000',
            'taxPercent'  => 0.1,
            'quickNumber' => 2520,
        ],
        [
            'downLevel'   => '144000',
            'upLevel'     => '300000',
            'taxPercent'  => 0.2,
            'quickNumber' => 16920,
        ],
        [
            'downLevel'   => '300000',
            'upLevel'     => '420000',
            'taxPercent'  => 0.25,
            'quickNumber' => 31920,
        ],
        [
            'downLevel'   => '420000',
            'upLevel'     => '660000',
            'taxPercent'  => 0.3,
            'quickNumber' => 52920,
        ],
        [
            'downLevel'   => '660000',
            'upLevel'     => '960000',
            'taxPercent'  => 0.35,
            'quickNumber' => 85920,
        ],
        [
            'downLevel'   => '960000',
            'upLevel'     => PHP_INT_MAX,
            'taxPercent'  => 0.45,
            'quickNumber' => 181920,
        ],
    ];
    
    /**
     *
     * @var array
     */
    public $taxes = [];
    
    /**
     * 月薪，扣税前
     *
     * @var int
     */
    private $salary;
    
    /**
     * 五险一金比例
     * 比如: 0.22
     *
     * @var float
     */
    private $socialSecurityPercent;
    
    /**
     * @var int
     */
    private $deductionMoney;
    
    public function calculateAllYear()
    {
        try {
            $this->calculateMonth(12);
            
            return array_sum(array_column($this->taxes, 'tax'));
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
    /**
     * 计算具体某一个月的扣税
     * [ 1 - 12 ]
     *
     * @param int $month
     *
     * @return float|int|mixed
     * @throws \Exception
     */
    public function calculateMonth(int $month)
    {
        if ($month < 1 or $month > 12) {
            throw new \Exception("月份必须是1-12");
        }
        
        //因为计算每个月的，必须计算这个月之前的收入，所以必须循环之前的收入
        //截止到这个月为止总的需缴税金额
        $moneyInYear = ($this->salary - $this->getSocialSecurityMoney() - self::BASE_TAX_MONEY - $this->deductionMoney) * $month;
        $taxInfo     = $this->searchTax($moneyInYear);
        
        //之前月份扣税
        $beforeMonthsTaxes = 0;
        for ($i = $month - 1; $i > 0; $i--) {
            $beforeMonthsTaxes += $this->calculateMonth($i);
        }
        
        //本月扣税
        $tax = $moneyInYear * $taxInfo['taxPercent'] - $taxInfo['quickNumber'] - $beforeMonthsTaxes;
        
        //本月所得钱
        $earnedMoney = $this->salary - $this->getSocialSecurityMoney() - $tax;
        
        
        $this->taxes[$month] = [
            'earnedMoney'       => $earnedMoney,
            'month'             => $month,
            'tax'               => $tax,
            'earnedMoneyInYear' => $moneyInYear,
            'socialSecurity'    => $this->getSocialSecurityMoney(),
            'taxPercent'        => $taxInfo['taxPercent'],
            'quickNumber'       => $taxInfo['quickNumber'],
            'beforeMonthTaxes'  => $beforeMonthsTaxes
        ];
        
        return $tax;
    }
    
    private function getSocialSecurityMoney()
    {
        return $this->salary * $this->socialSecurityPercent;
    }
    
    /**
     * 计算每个月的个税
     *
     * @param int $salary
     * @param int $month
     */
    private function calculateTax(int $salary, int $month)
    {
    
    }
    
    /**
     * 判断这个金额需要交多少
     *
     * @param int $money
     *
     * @return mixed
     * @throws \Exception
     */
    public function searchTax(int $money)
    {
        foreach (self::TAX_Levels as $taxLevel) {
            if ($money < $taxLevel['downLevel'] || $money > $taxLevel['upLevel']) {
                continue;
            }
            
            return $taxLevel;
        }
        throw new \Exception("找不到合适区间");
    }
    
    /**
     * TaxCalculator constructor.
     *
     * @param int   $salary                月薪（税前)
     * @param float $socialSecurityPercent 五险一金比例,默认22%
     * @param int   $deductionMoney        抵扣个税的专项扣除金额
     */
    public function __construct(int $salary, float $socialSecurityPercent = 0.22, int $deductionMoney = 0)
    {
        $this->salary                = $salary;
        $this->socialSecurityPercent = $socialSecurityPercent;
        $this->deductionMoney        = $deductionMoney;
    }
}

try {
    $salary         = intval($_POST['salary']);
    $deduction      = intval($_POST['deduction']);
    $socialSecurity = floatval($_POST['socialSecurity']) / 100;
//    (new TaxCalculator(30000, 0.22, 3000))->calculateMonth(1);
    $calculator = (new TaxCalculator($salary, $socialSecurity, $deduction));
    $calculator->calculateAllYear();
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel-heading">
                <p>
                    计算2019新版个税
                </p>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="/tax.php">
                        <div class="form-group">
                            <label for="firstname" class="col-sm-2 control-label">月薪(税前)</label>
                            <div class="col-sm-10">
                                <?php if(empty($_POST['salary'])): ?>
                                <input type="text" class="form-control" id="firstname" placeholder="请输入" name="salary">
                                <?php else: ?>
                                <input type="text" class="form-control" id="firstname" value="<?php echo $salary ?>" name="salary">
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deductionMoney" class="col-sm-2 control-label">专项扣除</label>
                            <div class="col-sm-10">
                                <?php if(!isset($_POST['deduction'])): ?>
                                    <input type="text" class="form-control" id="deductionMoney" placeholder="请输入" name="deduction">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="deductionMoney" value="<?php echo $deduction?>" name="deduction">
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="socialSecurity" class="col-sm-2 control-label">五险一金比例（默认22%)</label>
                            <div class="col-sm-10">
                                <?php if(empty($_POST['socialSecurity'])): ?>
                                    <input type="text" class="form-control" id="" placeholder="22" name="socialSecurity">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="" value="<?php echo $socialSecurity*100 ?>" name="socialSecurity">
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">登录</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <caption>全年个税</caption>
                <thead>
                <tr>
                    <th>月份</th>
                    <th>扣税</th>
                    <th>适用扣税比例</th>
                    <th>年应交税费额度</th>
                    <th>月收入</th>
                    <th>社保五险</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($calculator->taxes as $tax) {
                    $taxPercent = $tax['taxPercent'] * 100 . '%';
                    $tr         = "<tr>";
                    $tr         .= "<td>{$tax['month']}</td>";
                    $tr         .= "<td>{$tax['tax']}</td>";
                    $tr         .= "<td>{$taxPercent}</td>";
                    $tr         .= "<td>{$tax['earnedMoneyInYear']}</td>";
                    $tr         .= "<td>{$tax['earnedMoney']}</td>";
                    $tr         .= "<td>{$tax['socialSecurity']}</td>";
                    $tr         .= "</tr>";
                    echo $tr;
                }
                ?>
                </tbody>
                <tfoot>
                
                <tr>
                    <?php
                    $taxPercent        = $tax['taxPercent'] * 100 . '%';
                    $allTax            = array_sum(array_column($calculator->taxes, 'tax'));
                    $allMoney          = array_sum(array_column($calculator->taxes, 'earnedMoney'));
                    $allSocialSecurity = array_sum(array_column($calculator->taxes, 'socialSecurity'));
                    $tr                = "<tr class='warning'>";
                    $tr                .= "<td>全年</td>";
                    $tr                .= "<td>{$allTax}</td>";
                    $tr                .= "<td></td>";
                    $tr                .= "<td></td>";
                    $tr                .= "<td>{$allMoney}</td>";
                    $tr                .= "<td>{$allSocialSecurity}</td>";
                    $tr                .= "</tr>";
                    echo $tr;
                    ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</body>
</html>
