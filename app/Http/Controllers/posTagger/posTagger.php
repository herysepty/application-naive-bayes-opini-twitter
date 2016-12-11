<?php
namespace App\Http\Controllers\posTagger;
use DB;
class posTagger {
	private $word;
	private $tag ;
	private $pos_tag =	array(
								'JJ' => [
											'baik',
											'bagus',
										],
								'RB' => [
											'sementara',
											'nanti',
										],
								'NN' => [
											'kursi',
											'meja',
										],
								'NNP' => [
											'toyota',
											'honda',
										],
								'VBI' => [
											'motornya',
											'Pergi',
										],
								'VBT' => [
											'membeli',
											'Pergi',
										],
								'VBT' => [
											'di',
											'ke',
											'dari',
										],
								'SC' => [
											'jika',
											'ketika',
										],
								'DT' => [
											'para',
											'ini',
											'itu',
										],
								'UH' => [
											'wah',
											'aduh',
											'oi',
										],
								'CDO' => [
											'pertama',
											'kedua',
											'ketiga',
										],
								'CDC' => [
											'berdua'
										],
								'CDP' => [
											'satu',
											'dua',
											'tiga',
										],
								'CDI' => [
											'beberapa'
										],
								'PRP' => [
											'saya',
											'mereka'
										],
								'WP' => [
											'apa',
											'siapa',
											'dimana'
										],
								'PRN' => [
											'kedua-duanya'
										],
								'PRL' => [
											'sini',
											'situ',
											'ahok'
										],
								'NEG' => [
											'bukan',
											'tidak',
										],
							);


	public function tagger($term){
		$this->tag = [];
		foreach ($this->pos_tag as $key => $value) {
			if(in_array($term, $value)){
				$this->tag = $term.' '.$key;
				return $this->tag;
			}
		}
		return false;
	}

	public function ruleOpini() {
		$rule = [
					'RB JJ' => 	[
									'sangat baik', 
									'dengan baik',
									'agak baik',
								],
					'RB VB' => [
									'semoga berjalan', 
									'semoga membawa',
								],
					'NN JJ' => 	[
									'bukunya bagus', 
									'pakaianya rapi'
								],
					'NN VB' => 	[
									'pelajaran membosankan', 
									'perkataanya menjengkelkan',
								],
					'JJ VB' => 	[
									'mudah dipahami', 
									'gampang dimaafkan',
								],
					'CK JJ' => 	[
									'bagus atau baik', 
									'tetapi malas',
								],
					'JJ BB' => 	[
									'sama bagus', 
								],
					'VB VB' => 	[
									'membuat merinding', 
									'membikin pusing', 
								],
					'JJ RB' => 	[
									'indah sekali', 
									'bagus sekali', 
								],
					'VB JJ' => 	[
									'membikin bingung',
								],
					'NEG JJ' => 	[
									'tidak seindah',
									'tidak semudah',
								],
					'NEG VB' => 	[
									'tidak mengerti',
									'tidak memahami',
								],
					'PRP VBI' => 	[
									'saya menyukai',
								],
					'PRP VBT' => 	[
									'kita suka',
								],
					'VBT NN' => 	[
									'memiliki kedekatan',
								],
					'MD VBT' => 	[
									'perlu mengambil referensi',
								],
					'MD VBI' => 	[
									'perlu di kembangkan',
								],
		        ];
		 return $rule;
	}

	public function opini($term){
		$term = explode("\n", rtrim($term,"\n"));
		$tag = '';
		foreach ($term as $key => $value) {
			$arr = explode(' ',$value);
        	$tag .= $arr[1].' ';
		}

		echo $tag;
		foreach ($this->ruleOpini() as $key => $value) {
			if(strpos($tag, $key) !== false){
				echo "ada<br/>";
				return true;
			}else{
				return false;
			}
		}


	}
}