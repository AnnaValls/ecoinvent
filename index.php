<!doctype html><html><head>
	<meta charset=utf-8>
	<title>Ecoinvent</title>
	<style>
		body{
			font-family:sans-serif;
			margin-top:0;
		}
		h1{
			margin-top:5px;
		}
		ol{	
			counter-reset:item
		}
		li{
			display:block;
		}
		li:before{
			content:counters(item,".") ". "; 
			counter-increment:item;
		}

		#root li {
			padding-top:0.5em;
		}

		.description {
			display:inline-block;
			width:350px;
			font-size:13px;
		}

		.foldable.folded ol {
			display:none;
		}
		.foldable b {
			cursor:pointer;
		}
		.foldable b:hover {
			text-decoration:underline;
		}
	</style>
	<script>
		function init(){
			//init
		}
	</script>
</head><body onload=init()>

<h1>Ecoinvent web tool &mdash; User interface (draft)</h1>
<h2>All Inputs from the user (and default values)</h2>
<p>
	This is a draft for the <b>content</b> of the inputs of the web tool. 
	Click the categories to expand/contract.
</p>

<!--space--><hr>
<div>
	<div>
		Load from file
	</div>
	<div>
		<input type=file>
	</div>
</div>
<!--space--><hr>
<div>
	<button onclick=expAll()>Expand all</button>
	<button onclick=conAll()>Contract all</button>
	<script>
		function expAll() {
			var elements=document.querySelectorAll('li.foldable');
			for(var i=0;i<elements.length;i++) {
				elements[i].classList.remove('folded');
			}
		}
		function conAll() {
			var elements=document.querySelectorAll('li.foldable');
			for(var i=0;i<elements.length;i++) {
				elements[i].classList.add('folded');
			}
		}
	</script>
</div>
<!--space--><hr>

<!--input tree-->
<ol id=root>
	<li class="foldable folded">
		<b onclick=this.parentNode.classList.toggle('folded')>
			City characteristics
		</b>

		<ol>
			<li><span class=description>Population</span> <input value=1000>
			<li><span class=description>Equivalent inhabitants</span> <input value=1000>
			<li><span class=description>Country</span> 
				<select>
					<option>Country A
					<option>Country B
					<option>[...]
				</select>
			</li>
		</ol>
	</li>
	<li class="foldable folded">
		<b onclick=this.parentNode.classList.toggle('folded')>
			Wastewater characteristics [kg/m<sup>3</sup>]
		</b>
		<ol>
			<li class=foldable>
				<b onclick=this.parentNode.classList.toggle('folded')> Oxygen (O) </b>
				<ol>
					<li><span class=description> Total Chemical Oxygen Demand tCOD as O<sub>2</sub> </span><input value=0> </li>
					<li><span class=description> Soluble Chemical Oxygen Demand sCOD as O<sub>2</sub> </span><input value=0> </li>
					<li><span class=description> Biological Oxygen Demand BOD5 as O<sub>2</sub> </span><input value=0> </li>
				</ol>
			</li>
			<li class=foldable>
				<b onclick=this.parentNode.classList.toggle('folded')> Carbon (C) </b>
				<ol>
					<li><span class=description> Dissolved organic carbon DOC as C</span><input value=0> </li>
					<li><span class=description> Total organic carbon TOC as C</span><input value=0> </li>
				</ol>
			</li>
			<li class=foldable>
				<b onclick=this.parentNode.classList.toggle('folded')> Sulfur (S) </b>
				<ol>
					<li><span class=description> Sulfate SO<sub>4</sub> as S </span><input value=0> </li>
					<li><span class=description> Sulfide HS as S </span><input value=0> </li>
					<li><span class=description> Particulate S part as S </span><input value=0> </li>
					<li><span class=description> Total S tot. as S</span><input value=0> </li>
				</ol>
			</li>
			<li class=foldable>
				<b onclick=this.parentNode.classList.toggle('folded')> Nitrogen (N) </b>
				<ol>
					<li><span class=description> Ammonia NH<sub>4</sub> as N</span><input value=0> </li>
					<li><span class=description> Nitrate NO<sub>3</sub> as N</span><input value=0> </li>
					<li><span class=description> Nitrite NO<sub>2</sub> as N</span><input value=0> </li>
					<li><span class=description> Particulate N part. as N </span><input value=0> </li>
					<li><span class=description> Organic soluble N org. sol. as N </span><input value=0> </li>
					<li><span class=description> Soluble Kjeldahl SKN as N</span><input value=0> </li>
					<li><span class=description> Total Kjeldahl TKN as N </span><input value=0> </li>
					<li><span class=description> Total Nitrogen N-tot. as N</span><input value=0> </li>
				</ol>
			</li>
			<li class=foldable>
				<b onclick=this.parentNode.classList.toggle('folded')>
					Phosphorus (P)
				</b>
				<ol>
					<li><span class=description> Phosphate PO<sub>4</sub> as P </span><input value=0> </li>
					<li><span class=description> Particulate P-part. as P </span><input value=0> </li>
					<li><span class=description> Total P-tot. as P</span><input value=0> </li>
				</ol>
			</li>
			<li><span class=description> Boron B</span><input value=0> </li>
			<li><span class=description> Chlorine Cl</span><input value=0> </li>
			<li><span class=description> Bromium Br</span><input value=0> </li>
			<li><span class=description> Fluorine F</span><input value=0> </li>
			<li><span class=description> Iodine I</span><input value=0> </li>
			<li><span class=description> Silver Ag</span><input value=0> </li>
			<li><span class=description> Arsenic As</span><input value=0> </li>
			<li><span class=description> Barium Ba</span><input value=0> </li>
			<li><span class=description> Cadmium Cd</span><input value=0> </li>
			<li><span class=description> Cobalt Co</span><input value=0> </li>
			<li><span class=description> Chromium Cr</span><input value=0> </li>
			<li><span class=description> Copper Cu</span><input value=0> </li>
			<li><span class=description> Mercury Hg</span><input value=0> </li>
			<li><span class=description> Manganese Mn</span><input value=0> </li>
			<li><span class=description> Molybdenum Mo</span><input value=0> </li>
			<li><span class=description> Nickel Ni</span><input value=0> </li>
			<li><span class=description> Lead Pb</span><input value=0> </li>
			<li><span class=description> Antimony Sb</span><input value=0> </li>
			<li><span class=description> Selenium Se</span><input value=0> </li>
			<li><span class=description> Tin Sn</span><input value=0> </li>
			<li><span class=description> Vanadium V</span><input value=0> </li>
			<li><span class=description> Zinc Zn</span><input value=0> </li>
			<li><span class=description> Beryllium Be</span><input value=0> </li>
			<li><span class=description> Scandium Sc</span><input value=0> </li>
			<li><span class=description> Strontium Sr</span><input value=0> </li>
			<li><span class=description> Titanium Ti</span><input value=0> </li>
			<li><span class=description> Thallium Tl</span><input value=0> </li>
			<li><span class=description> Tungsten W</span><input value=0> </li>
			<li><span class=description> Silicon Si</span><input value=0> </li>
			<li><span class=description> Iron Fe </span><input value=0> </li>
			<li><span class=description> Calcium Ca</span><input value=0> </li>
			<li><span class=description> Aluminium Al</span><input value=0> </li>
			<li><span class=description> Potassium K</span><input value=0> </li>
			<li><span class=description> Magnesium Mg</span><input value=0> </li>
			<li><span class=description> Sodium Na</span><input value=0> </li>
		</ol>
	</li>
	<li class="foldable">
		<b onclick=this.parentNode.classList.toggle('folded')>
			Treatment plant characteristics
		</b>
		<ol>
			<li class="foldable folded">
				<b onclick=this.parentNode.classList.toggle('folded')>
					Liquid treatment line unit processes
				</b>
				<ol>
					<li>
						<span class=description>Pumping </span>
						<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Preliminary: to remove trash and grit
						</b>
						<ol>
							<li>
								<span class=description>Screening</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Degritting</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Neutralization</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Equalization</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Primary: to remove settleable matter
						</b>
						<ol>
							<li>
								<span class=description>Primary clarification</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Chemical addition</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Secondary: to remove organic matter (BOD<sub>5</sub>, TSS)
						</b>
						<ol>
							<li>
								<span class=description>Activated sludge</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Lagoon (anaerobic, facultative, aerobic)</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Constructed wetlands</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Tertiary: to remove ammonia, total nitrogen, total phosphorus, metals
						</b>
						<ol>
							<li>
								<span class=description>Multistage activated sludge</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Multistage biofilm processes</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Chemical addition</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Advanced: to reach low levels of TSS, BOD5, total nitrogen, total phosphorus, pathogens
						</b>
						<ol>
							<li>
								<span class=description>Filtration</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Ultrafiltration</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Disinfection(e.g.Cl2,UV,O3)</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Activated carbon</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
				</ol>
			</li>
			<li class=foldable>
				<b onclick=this.parentNode.classList.toggle('folded')>
					Solids treatment line unit processes
				</b>
				<ol>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Thickening: to increase the solids content 
						</b>
						<ol>
							<li>
								<span class=description>Gravity thickening</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Digestion: to stabilize organic matter 
						</b>
						<ol>
							<li>
								<span class=description>Anaerobic digestion</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Aerobic digestion</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Conditioning: to improve dewatering
						</b>
						<ol>
							<li>
								<span class=description>Coagulant and polymer addition</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Dewatering: to increase the solids content
						</b>
						<ol>
							<li>
								<span class=description>Centrifugation</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Filter pressing</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Vacuuming</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Nutrient treatment and recovery
						</b>
						<ol>
							<li>
								<span class=description>Struvite formation</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Anammox</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Drying: to increase the solids content
						</b>
						<ol>
							<li>
								<span class=description>Sludge beds</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Heat drying</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
					<li class=foldable>
						<b onclick=this.parentNode.classList.toggle('folded')>
							Sludge or biosolids disposal
						</b>
						<ol>
							<li>
								<span class=description>Composting</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Land application</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Landfilling</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
							<li>
								<span class=description>Incineration</span>
								<select> <option>None <option>option 1 <option>option 2 <option>[...] </select>
							</li>
						</ol>
					</li>
				</ol>
			</li>
		</ol>
	</li>
</ol>
