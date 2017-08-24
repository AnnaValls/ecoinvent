<!doctype html><html><head>
	<meta charset=utf-8>
	<meta name="viewport" content="width=device-width">
	<meta name="description" content="ecoinvent">
	<title>Wastewater configuration</title>
</head><body>

<h1>Wastewater configuration</h1>
<h2>Wastewater characteristics</h2>

<ul>
	<li>
		<span>Volume (m<sup>3</sup>)</span>
		<input value=0>
	</li>
	<li>
		<span>Origin</span>
		<select>
			<option>Industrial process wastewater
			<option>Municipal wastewater
			<option>Other
		</select>
	</li>
	<li class=foldable>
		<b onclick=this.parentNode.classList.toggle('folded')> Oxygen (O) </b>
		<ul>
			<li>
				<span class=description> Total Chemical Oxygen Demand tCOD as O<sub>2</sub> (kg/m<sup>3</sup>) </span>
				<input value=0> 
			</li>
			<li><span class=description> Soluble Chemical Oxygen Demand sCOD as O<sub>2</sub> (kg/m<sup>3</sup>)  </span><input value=0> </li>
			<li><span class=description> Biological Oxygen Demand BOD5 as O<sub>2</sub> (kg/m<sup>3</sup>)  </span><input value=0> </li>
		</ul>
	</li>
	<li class=foldable>
		<b onclick=this.parentNode.classList.toggle('folded')> Carbon (C) </b>
		<ul>
			<li><span class=description> Dissolved organic carbon DOC as C (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Total organic carbon TOC as C (kg/m<sup>3</sup>) </span><input value=0> </li>
		</ul>
	</li>
	<li class=foldable>
		<b onclick=this.parentNode.classList.toggle('folded')> Sulfur (S) </b>
		<ul>
			<li><span class=description> Sulfate SO<sub>4</sub> as S  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Sulfide HS as S  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Particulate S part as S  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Total S tot. as S (kg/m<sup>3</sup>) </span><input value=0> </li>
		</ul>
	</li>
	<li class=foldable>
		<b onclick=this.parentNode.classList.toggle('folded')> Nitrogen (N) </b>
		<ul>
			<li><span class=description> Ammonia NH<sub>4</sub> as N (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Nitrate NO<sub>3</sub> as N (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Nitrite NO<sub>2</sub> as N (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Particulate N part. as N  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Organic soluble N org. sol. as N  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Soluble Kjeldahl SKN as N (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Total Kjeldahl TKN as N  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Total Nitrogen N-tot. as N (kg/m<sup>3</sup>) </span><input value=0> </li>
		</ul>
	</li>
	<li class=foldable>
		<b onclick=this.parentNode.classList.toggle('folded')>
			Phosphorus (P)
		</b>
		<ul>
			<li><span class=description> Phosphate PO<sub>4</sub> as P  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Particulate P-part. as P  (kg/m<sup>3</sup>) </span><input value=0> </li>
			<li><span class=description> Total P-tot. as P (kg/m<sup>3</sup>) </span><input value=0> </li>
		</ul>
	</li>
	<li><span class=description> Boron      (B)  (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Chlorine   (Cl) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Bromium    (Br) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Fluorine   (F)  (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Iodine     (I)  (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Silver     (Ag) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Arsenic    (As) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Barium     (Ba) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Cadmium    (Cd) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Cobalt     (Co) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Chromium   (Cr) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Copper     (Cu) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Mercury    (Hg) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Manganese  (Mn) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Molybdenum (Mo) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Nickel     (Ni) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Lead       (Pb) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Antimony   (Sb) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Selenium   (Se) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Tin        (Sn) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Vanadium   (V)  (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Zinc       (Zn) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Beryllium  (Be) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Scandium   (Sc) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Strontium  (Sr) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Titanium   (Ti) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Thallium   (Tl) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Tungsten   (W)  (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Silicon    (Si) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Iron       (Fe) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Calcium    (Ca) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Aluminium  (Al) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Potassium  (K)  (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Magnesium  (Mg) (kg/m<sup>3</sup>) </span><input value=0> </li>
	<li><span class=description> Sodium     (Na) (kg/m<sup>3</sup>) </span><input value=0> </li>
</ul>

<button>Save</button>
