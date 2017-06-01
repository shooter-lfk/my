function codeIn(code, arr){
	return arr.indexOf(code)!=-1;
}

/**
 * 算法模型
 *　func(betData, kjData, betWeiShu)
 *
 * @params betData		投注号码
 * @params kjData		开奖号码
 * @params betWeiShu	投注位数，一般不用，在任选的时候用
 *
 * @return 				返回中奖注数，如果不中奖，则返回0
 *
 * @throw				遇到不明的可以抛出，抛出等于忽略，手工处理
 */
//{{{ 时时彩

//{{{ 五星彩多星玩法

// 五星单式
exports.dxwf5d=function(betData, kjData){
	return ds(betData, kjData);
}

// 五星复式
exports.dxwf5f=function(betData, kjData){
	return fs(betData, kjData);
}

// 前4复式
exports.dxwfQ4f=function(betData, kjData){
	return fs(betData, kjData.removeFromList(',', 5));
}

// 前4单式
exports.dxwfQ4d=function(betData, kjData){
	return ds(betData, kjData.removeFromList(',', 5));
}

// 后4复式
exports.dxwfH4f=function(bet, kj){
	return fs(bet, kj.removeFromList(',',1));
}

// 后4单式
exports.dxwfH4d=function(bet, kj){
	return ds(bet, kj.removeFromList(',',1));
}

// 任选4复式
exports.dxwfR4f=function(bet, kj){
	var w=bet.split(',').indexOf('-')+1;
	kj=kj.replaceList('-', w);
	return fs(bet, kj);
}

// 任选4单式
exports.dxwfR4d=function(bet, kj){
	var w=bet.substr(0,9).split(',').indexOf('-')+1;
	kj=kj.replaceList('-', w);
	return ds(bet, kj);
}

//}}}

//{{{ 三星玩法

// 前三复式
exports.sxwfQ3f=function(bet, kj){
	return fs(bet, kj.removeFromList(',', 4, 5));
}

// 前三单式
exports.sxwfQ3d=function(bet, kj){
	return ds(bet, kj.removeFromList(',', 4,5));
}

// 后三复式
exports.sxwfH3f=function(bet, kj){
	return fs(bet, kj.removeFromList(',', 1, 2));
}

// 后三单式
exports.sxwfH3d=function(bet, kj){
	return ds(bet, kj.removeFromList(',', 1,2));
}

// 任选三复式
exports.sxwfR3f=function(bet, kj){
	bet.split(',').map(function(v, i){
		if(v=='-') kj=kj.replaceList('-',i+1);
	});
	
	return fs(bet, kj);
}

// 任选三单式
exports.sxwfR3d=function(bet, kj){
	bet.substr(0,9).split(',').map(function(v, i){
		if(v=='-') kj=kj.replaceList('-',i+1);
	});
	
	return ds(bet, kj);
}

//}}}

//{{{ 三星组选

// 前三组三
exports.sxzxQ3z3=function(bet, kj){
	
	return z3(bet, kj.substr(0,5));
}

// 前三组六
exports.sxzxQ3z6=function(bet, kj){
	return z6(bet, kj.substr(0,5));
}

// 前三混合组选
exports.sxzxQ3h=function(bet, kj){

}

// 后三组三
exports.sxzxH3z3=function(bet, kj){
	//console.log('投注：%s，开奖号：%s，中奖注数：%d', bet, kj, z3(bet, kj.substr(4,9)));
	return z3(bet, kj.substr(4,9));
}

// 4x后三组三
exports.sxzxH43z3=function(bet, kj){
	return z3(bet, kj.substr(2,7));
}

// 后三组六
exports.sxzxH3z6=function(bet, kj){
	return z6(bet, kj.substr(4,9));
}
// 4x后三组六
exports.sxzxH43z6=function(bet, kj){
	return z6(bet, kj.substr(2,7));
}

// 后三混合组选
exports.sxzxH3h=function(bet, kj){

}

// 任三组三
exports.sxzxR3z3=function(bet, kj, w){
	kj=kj.split(',');
	[16, 8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return z3(bet, kj);
}
// 4x任三组三
exports.sxzxR43z3=function(bet, kj, w){
	kj=kj.split(',');
	[8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return z3(bet, kj);
}

// 任三组六
exports.sxzxR3z6=function(bet, kj, w){
	kj=kj.split(',');
	[16, 8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return z6(bet, kj);
}
// 4x任三组六
exports.sxzxR43z6=function(bet, kj, w){
	kj=kj.split(',');
	[8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return z6(bet, kj);
}

// 任三混合组
exports.sxzxR3h=function(bet, kj, w){

}

//}}}

//{{{ 二星直选

// 前二复式
exports.rxwfQ2f=function(bet, kj){
	return fs(bet, kj.substr(0,3));
}

// 前二单式
exports.rxwfQ2d=function(bet, kj){
	return ds(bet, kj.substr(0,3));
}

// 后二复式
exports.rxwfH2f=function(bet, kj){
	return fs(bet, kj.substr(6,9));
}

// 后二单式
exports.rxwfH2d=function(bet, kj){
	return ds(bet, kj.substr(6,9));
}
// 4x后二复式
exports.rxwfH42f=function(bet, kj){
	return fs(bet, kj.substr(4,7));
}

// 4x后二单式
exports.rxwfH42d=function(bet, kj){
	return ds(bet, kj.substr(4,7));
}

// 任选二复式
exports.rxwfR2f=exports.sxwfR3f;

// 任选二单式
exports.rxwfR2d=exports.sxwfR3d;


// 4x任选二复式
exports.rxwfR42f=exports.rxwfH42f;

// 4x任选二单式
exports.rxwfR42d=exports.rxwfH42d;
//}}}

//{{{ 二星组选

// 前二组复式
exports.rxzxQ2f=function(bet, kj){
	return z2f(bet, kj.substr(0,3));
}

// 前二组单式
exports.rxzxQ2d=function(bet, kj){
	return z2d(bet, kj.substr(0,3));
}

// 后二组复式
exports.rxzxH2f=function(bet, kj){
	return z2f(bet, kj.substr(6,9));
}

// 后二组单式
exports.rxzxH2d=function(bet, kj){
	return z2d(bet, kj.substr(6,9));
}
// 4x后二组复式
exports.rxzxH42f=function(bet, kj){
	return z2f(bet, kj.substr(4,7));
}

// 4x后二组单式
exports.rxzxH42d=function(bet, kj){
	return z2d(bet, kj.substr(4,7));
}

// 任选二组选复式
exports.rxzxR2f=function(bet, kj, w){
	kj=kj.split(',');
	[16, 8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return z2f(bet, kj);
}
// 4x任选二组选复式
exports.rxzxR42f=function(bet, kj, w){
	kj=kj.split(',');
	[8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return z2f(bet, kj);
}

// 任选二组选单式
exports.rxzxR2d=function(bet, kj, w){
	kj=kj.split(',');
	[16, 8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	//console.log(kj);
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	bet=bet.split('|').map(function(b){
		b=b.split(',');
		[16, 8, 4, 2, 1].forEach(function(v, i){
			if((w&v)==0) delete b[i];
		});
		return b.filter(function(v){
			return v!=undefined;
		}).join(',');
	}).join('|');
	
	return z2d(bet, kj);
}
// 4x任选二组选单式
exports.rxzxR42d=function(bet, kj, w){
	kj=kj.split(',');
	[8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	//console.log(kj);
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	bet=bet.split('|').map(function(b){
		b=b.split(',');
		[8, 4, 2, 1].forEach(function(v, i){
			if((w&v)==0) delete b[i];
		});
		return b.filter(function(v){
			return v!=undefined;
		}).join(',');
	}).join('|');
	
	return z2d(bet, kj);
}


//}}}

//{{{ 五星定位胆

exports.dwd5x=function(bet, kj){
	kj=kj.split(',');
	var count=0;
	
	bet.split(',').map(function(v, i){
		if(v.length>1){
			v.split('').map(function(s){
				if(s==kj[i]) count++;
			});
		}else{
			if(v==kj[i]) count++;
		}
	});
	
	return count;
}

//}}}

//{{{ 不定胆

// 后三不定胆
exports.bddH3=function(bet, kj){
	kj=kj.substr(4,7);
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}
// 4x后三不定胆
exports.bddH43=function(bet, kj){
	kj=kj.substr(2,5);
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}

// 前三不定胆
exports.bddQ3=function(bet, kj){
	kj=kj.substr(0,5);
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}

// 中三不定胆
exports.bddZ3=function(bet, kj){
	kj=kj.substr(2,5);
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}

// 任选三不定胆
exports.bddR3=function(bet, kj, w){
	kj=kj.split(',');
	[16, 8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}
// 4x任选三不定胆
exports.bddR43=function(bet, kj, w){
	kj=kj.split(',');
	[8, 4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}

//}}}

//{{{ 大小单双

// 前二大小单双
exports.dsQ2=function(bet, kj){
	return dxds(bet, kj.substr(0,3));
}

// 后二大小单双
exports.dsH2=function(bet, kj){
	return dxds(bet, kj.substr(6,9));
}
// 4x后二大小单双
exports.dsH2=function(bet, kj){
	return dxds(bet, kj.substr(4,7));
}

// 任选二大小单双
exports.dsR2=function(bet, kj, w){
	kj=kj.split(',');
	bet=bet.split(',').filter(function(v, i){
		if(v=='-'){
			delete kj[i];
		}else{
			return v;
		}
	}).join(',');
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return dxds(bet, kj);
}

//}}}

// 时时彩结束
//}}}



//{{{ 福彩3D

// 三星直选－复式
exports.fc3dFs=fs;

// 三星直选－单式
exports.fc3dDs=ds;



// 三星组选－组三
exports.fc3dZ3=z3;

// 三星组选－组六
exports.fc3dZ6=z6;



// 二星直选－前二单式
exports.fc3dQ2d=exports.rxwfQ2d;

// 二星直选－前二复式
exports.fc3dQ2f=exports.rxwfQ2f;

// 二星直选－后二单式
exports.fc3dH2d=function(bet, kj){
	return ds(bet, kj.substr(2,5));
}

// 二星直选－后二复式
exports.fc3dH2f=function(bet, kj){
	return fs(bet, kj.substr(2,5));
}



// 二星组选－前二组选单式
exports.fc3dZQ2d=exports.rxzxQ2d;

// 二星组选－前二组选复式
exports.fc3dZQ2f=exports.rxzxQ2f;

// 二星组选－后二组选单式
exports.fc3dZH2d=function(bet, kj){
	return z2d(bet, kj.substr(2,5));
}

// 二星组选－后二组选复式
exports.fc3dZH2f=function(bet, kj){
	return z2f(bet, kj.substr(2,5));
}


// 三星定位胆
exports.fc3d3xdw=exports.dwd5x;



// 不定胆
exports.fc3dbdd=exports.bddQ3;


// 后二大小单双
exports.fc3dH2dxds=function(bet, kj){
	return dxds(bet, kj.substr(2,5));
}

// 任选二大小单双
exports.fc3dR2dxds=function(bet, kj, w){
	kj=kj.split(',');
	[4, 2, 1].forEach(function(v, i){
		if((w&v)==0) delete kj[i];
	});
	kj=kj.filter(function(v){
		return v!=undefined;
	}).join(',');
	
	return dxds(bet, kj);
}


//}}}


//{{{ 十一选五玩法

// 任选一
exports.gd11x5R1=function(bet, kj){
	return bet.split(' ').filter(function(v){
		return kj.indexOf(v)!=-1;
	}).length;
}
exports.gd11x5R2=function(bet, kj){
	return rx(bet, kj, 2);
}
exports.gd11x5R3=function(bet, kj){
	return rx(bet, kj, 3);
}
exports.gd11x5R4=function(bet, kj){
	return rx(bet, kj, 4);
}
exports.gd11x5R5=function(bet, kj){
	return rx(bet, kj, 5);
}
exports.gd11x5R6=function(bet, kj){
	return rx(bet, kj, 6);
}
exports.gd11x5R7=function(bet, kj){
	return rx(bet, kj, 7);
}
exports.gd11x5R8=function(bet, kj){
	return rx(bet, kj, 8);
}
//exports.gd11x5R9=function(bet, kj){
//	return rx(bet, kj, 9);
//}
//exports.gd11x5R10=function(bet, kj){
//	return rx(bet, kj, 10);
//}

// 前一直选
exports.gd11x5Q1=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,2).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前一大小单双
exports.gd11x5Q1dx=function(bet, kj){
	return dxds(bet, kj.substr(0,5));
}

// 前二直选
exports.gd11x5Q2=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,5).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前二组选
exports.gd11x5Q2z=function(bet, kj){
	return zx(bet, kj.substr(0,5));
}

// 前三直选
exports.gd11x5Q3=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,8).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前三组选
exports.gd11x5Q3z=function(bet, kj){
	return zx(bet, kj.substr(0,8));
}

// 前三不定胆
exports.gs11x5Q3bdw=function(bet, kj){
	kj=kj.substr(0,8);
	bet=bet.split('').filter(function(v){
		return kj.indexOf(v)!=-1;
	});
	
	return bet.length;
}

// 前四直选
exports.gd11x5Q4=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,11).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前五直选
exports.gd11x5Q5=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,14).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前六直选
exports.gd11x5Q6=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,17).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前七直选
exports.gd11x5Q7=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,20).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前八直选
exports.gd11x5Q8=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,23).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前九直选
exports.gd11x5Q9=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,26).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

// 前十直选
exports.gd11x5Q10=function(bet, kj){
	bet=bet.split(',');
	return kj.substr(0,29).split(',')
	.some(function(v,i){
		return bet[i].indexOf(v)==-1;
	})?0:1;
}

//}}}

//{{{ 常用算法

/**
 * 常用复式算法
 *
 * @params bet		投注列表：123,45,2,59
 * @params data		开奖所需的那几个：4,5,0,8
 *
 * @return 			返回中奖注数
 */
function fs(bet, data){
	
	// 笛卡尔乘取得所投的号码
	return DescartesAlgorithm.apply(null, bet.split(',').map(function(v){return v.split('')}))
	
	// 把号码由数组变成字符串，以便比较
	.map(function(v){ return v.join(','); })
	
	// 过滤掉不中奖的号码
	.filter(function(v){ return v==data})
	
	// 返回中奖号码的总数
	.length;
}

/**
 * 单式算法
 *
 * @params bet		投注列表：1,5,2,9|3,2,4,6
 * @params data		开奖所需的那几位号码：4,5,3,6
 *
 * @return			返回中奖注数
 */
function ds(bet, data){
	return bet.split('|')
	.filter(function(v){ return v==data})
	.length;
}

/**
 * 组三
 *
 * @params bet		投注列表：135687或112,334
 * @params data		开奖所需的那几位号码：4,5,3
 *
 * @return			返回中奖注数
 */
function z3(bet, data){
	
	// 豹子不算中奖
	if(data.match(/^(\d),\1,\1/)) return 0;
	var reg=/(\d)\d?\1/;
	
	if(bet.indexOf(',')!=-1||reg.test(bet)){
		// 单选处理
		bet=bet.split(',');
		data=data.split(',').join('');
		
		var m=data.match(reg);
		if(!m) return 0;		// 如果三位数没有相同，则不中奖
		m=m[1];		// 重复位数
		reg=new RegExp(m, 'g')
		var s=data.replace(reg,'');	// 不重复的位数
		
		return bet.filter(function(v){
			//console.log('v:%s, s:%s', v, s);
			//console.log(reg);
			return v.replace(reg,'')==s;
		}).length;
	}else{
		// 复选处理
		bet=combine(bet.split(''),2).map(function(v){return v.join(',')});
		data=data.split(',');
		return bet.filter(function(v){
			var i=0;
			for(i in data){
				if(v.indexOf(data[i])==-1) return false;
			}
			return true;
		})
		.length;
	}

}

/**
 * 组六
 *
 * @params bet		投注列表：135687
 * @params data		开奖所需的那几位号码：4,5,3
 *
 * @return			返回中奖注数
 */
function z6(bet, data){
	
	// 豹子不算中奖
	if(data.match(/^(\d),\1,\1/)) return 0;
	
	data=permutation(data.split(','),3).map(function(v){return v.join('');});
	if(bet.indexOf(',')!=-1){
		// 录入式投注
		bet=bet.split(',');
	}else{
		// 点击按钮投注
		bet=combine(bet.split(""),3).map(function(v){return v.join("");});
	}
	return bet.filter(function(v){return data.indexOf(v)!=-1}).length;
}

/**
 * 组二复式
 *
 * @params bet		投注列表：135687
 * @params data		开奖所需的那几位号码：4,5
 *
 * @return			返回中奖注数
 */
function z2f(bet, data){
	data=data.split(',');
	var data1=data.join('');
	data=data.reverse().join('');
	return combine(bet.split(''), 2)
	.map(function(v){return v.join('');})
	.filter(function(v){
		return v==data||v==data1;
	}).length;
}

/**
 * 组二单式
 *
 * @params bet		投注列表：1,3|5,6|8,7
 * @params data		开奖所需的那几位号码：4,5
 *
 * @return			返回中奖注数
 */
function z2d(bet, data){
	var data1=data.reverse();
	return bet.split('|').filter(function(v){
		return v==data||v==data1;
	}).length;
}


/**
 * 大小单双
 *
 * @params bet		投注列表：大单,小单
 * @params data		开奖所需的那几位号码：4,5
 *
 * @return			返回中奖注数
 */
function dxds(bet, data){
	
	data=data.split(',');
	return DescartesAlgorithm.apply(null, bet.split(',').map(function(v){return v.split('')}))
	.filter(function(v){
		//console.log(v);
		var o={
			'大':'56789',
			'小':'01234',
			'单':'13579',
			'双':'02468'
		};
		//throw(v[0]);
		return o[v[0]].indexOf(data[0])!=-1 && o[v[1]].indexOf(data[1])!=-1
	})
	.length;
}

function rx(bet, kj, num){
	
	var m,reg=/^\(([\d ]+)\)([\d ]+)$/;
	if(m=bet.match(reg)){
		// 胆拖投注
		var d=m[1].split(' ');
		
		if(d.some(function(c){return kj.indexOf(c)==-1})) return 0;
		
		return combine(m[2].split(' '), num-d.length)
		.filter(function(v){
			if(num<5||num<8){
				return v.every(function(c){
					return kj.indexOf(c)!=-1;
				});
			}else{
				v=v.concat(d);
				return kj.split(',').every(function(c){
					return v.indexOf(c)!=-1;
				});
			}
		}).length;
	}else{
		// 普通投注
		
		return combine(bet.split(' '), num)
		.filter(function(v){
			if(num<8){
				return v.every(function(c){
					return kj.indexOf(c)!=-1;
				});
			}else{
				return kj.split(',').every(function(c){
					return v.indexOf(c)!=-1;
				});
			}
		}).length;
	}
}

function zx(bet, kj){
	var m,reg=/^\(([\d ]+)\)([\d ]+)$/;
	kj=kj.split(',');
	if(m=bet.match(reg)){
		// 胆拖投注
		var d=m[1].split(' ');
		if(d.some(function(c){return kj.indexOf(c)==-1})) return 0;
		return combine(m[2].split(' '), kj.length-d.length)
		.filter(function(v){
			return v.every(function(c){
				return kj.indexOf(c)!=-1;
			});
		}).length;
	}else{
		// 普通投注
		return combine(bet.split(' '), kj.length)
		.filter(function(v){
			return v.every(function(c){
				return kj.indexOf(c)!=-1;
			});
		}).length;
	}
}



/**
 * 笛卡尔乘积算法
 *
 * @params 一个可变参数，原则上每个都是数组，但如果数组只有一个值是直接用这个值
 *
 * useage:
 * console.log(DescartesAlgorithm(2, [4,5], [6,0],[7,8,9]));
 */
function DescartesAlgorithm(){
	var i,j,a=[],b=[],c=[];
	if(arguments.length==1){
		if(!Array.isArray(arguments[0])){
			return [arguments[0]];
		}else{
			return arguments[0];
		}
	}
	
	if(arguments.length>2){
		for(i=0;i<arguments.length-1;i++) a[i]=arguments[i];
		b=arguments[i];
		
		return arguments.callee(arguments.callee.apply(null, a), b);
	}

	if(Array.isArray(arguments[0])){
		a=arguments[0];
	}else{
		a=[arguments[0]];
	}
	if(Array.isArray(arguments[1])){
		b=arguments[1];
	}else{
		b=[arguments[1]];
	}

	for(i=0; i<a.length; i++){
		for(j=0; j<b.length; j++){
			if(Array.isArray(a[i])){
				c.push(a[i].concat(b[j]));
			}else{
				c.push([a[i],b[j]]);
			}
		}
	}
	
	return c;
}

/**
 * 组合算法
 *
 * @params Array arr		备选数组
 * @params Int num
 *
 * @return Array			组合
 *
 * useage:  combine([1,2,3,4,5,6,7,8,9], 3);
 */
function combine(arr, num) {
	var r = [];
	(function f(t, a, n) {
		if (n == 0) return r.push(t);
		for (var i = 0, l = a.length; i <= l - n; i++) {
			f(t.concat(a[i]), a.slice(i + 1), n - 1);
		}
	})([], arr, num);
	return r;
}

/**
 * 排列算法
 */
function permutation(arr, num){
	var r=[];
	(function f(t,a,n){
		if (n==0) return r.push(t);
		for (var i=0,l=a.length; i<l; i++){
			f(t.concat(a[i]), a.slice(0,i).concat(a.slice(i+1)), n-1);
		}
	})([],arr,num);
	return r;
}

//}}}