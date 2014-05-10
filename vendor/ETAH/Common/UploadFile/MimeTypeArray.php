<?php
/**
 * 
 * @author Edward_sj
 *
 */
namespace Etah\Common\UploadFile;

class MimeTypeArray {
	
	static function getMimeType() {
		
		return array (
				'3dm' => array (
						0 => 'model/vnd.flatland.3dml',
						1 => 'text/vnd.in3d.3dml',
						2 => 'x-world/x-3dmf' 
				),
				'3dmf' => 'x-world/x-3dmf',
				'3dml' => array (
						0 => 'model/vnd.flatland.3dml',
						1 => 'text/vnd.in3d.3dml' 
				),
				'3gp' => 'video/3gpp',
				'a' => 'application/octet-stream',
				'aab' => array (
						0 => 'application/x-authorware-bin',
						1 => 'application/x-authoware-bin' 
				),
				'aam' => array (
						0 => 'application/x-authorware-map',
						1 => 'application/x-authoware-map' 
				),
				'aas' => array (
						0 => 'application/x-authorware-seg',
						1 => 'application/x-authoware-seg' 
				),
				'abc' => 'text/vnd.abc',
				'acc' => 'chemical/x-synopsys-accord',
				'acgi' => 'text/html',
				'acu' => 'application/vnd.acucobol',
				'acx' => 'application/internet-property-stream',
				'aep' => 'application/vnd.audiograph',
				'afl' => 'video/animaflex',
				'afp' => 'application/vnd.ibm.modcap',
				'ai' => 'application/postscript',
				'aif' => array (
						0 => 'audio/aiff',
						1 => 'audio/x-aiff' 
				),
				'aifc' => array (
						0 => 'audio/aiff',
						1 => 'audio/x-aiff' 
				),
				'aiff' => array (
						0 => 'audio/aiff',
						1 => 'audio/x-aiff' 
				),
				'aim' => 'application/x-aim',
				'aip' => 'text/x-audiosoft-intra',
				'als' => 'audio/X-Alpha5',
				'amc' => 'application/x-mpeg',
				'ani' => array (
						0 => 'application/octet-stream',
						1 => 'application/x-navi-animation' 
				),
				'ano' => 'application/x-annotator',
				'aos' => 'application/x-nokia-9000-communicator-add-on-software',
				'apm' => 'application/studiom',
				'apr' => 'application/vnd.lotus-approach',
				'aps' => 'application/mime',
				'arc' => 'application/octet-stream',
				'arj' => array (
						0 => 'application/arj',
						1 => 'application/octet-stream' 
				),
				'art' => 'image/x-jg',
				'asc' => 'text/plain',
				'asd' => 'application/astound',
				'asf' => array (
						0 => 'application/vnd.ms-asf',
						1 => 'video/x-ms-asf' 
				),
				'asm' => 'text/x-asm',
				'asn' => 'application/astound',
				'aso' => 'application/vnd.accpac.simply.aso',
				'asp' => array (
						0 => 'application/x-asap',
						1 => 'text/asp' 
				),
				'asr' => 'video/x-ms-asf',
				'asx' => array (
						0 => 'application/x-mplayer2',
						1 => 'video/x-ms-asf',
						2 => 'video/x-ms-asf-plugin' 
				),
				'au' => array (
						0 => 'audio/basic',
						1 => 'audio/x-au' 
				),
				'avb' => 'application/octet-stream',
				'avi' => array (
						0 => 'application/x-troff-msvideo',
						1 => 'video/avi',
						2 => 'video/msvideo',
						3 => 'video/quicktime',
						4 => 'video/x-msvideo' 
				),
				'avs' => 'video/avs-video',
				'avx' => 'video/x-rad-screenplay',
				'awb' => 'audio/amr-wb',
				'bas' => 'text/plain',
				'bcpio' => 'application/x-bcpio',
				'bh2' => 'application/vnd.fujitsu.oasysprs',
				'bin' => array (
						0 => 'application/mac-binary',
						1 => 'application/macbinary',
						2 => 'application/octet-stream',
						3 => 'application/x-binary',
						4 => 'application/x-macbinary' 
				),
				'bld' => 'application/bld',
				'bld2' => 'application/bld2',
				'bm' => 'image/bmp',
				'bmi' => 'application/vnd.bmi',
				'bmp' => array (
						0 => 'application/x-MS-bmp',
						1 => 'image/bitmap',
						2 => 'image/bmp',
						3 => 'image/x-bmp',
						4 => 'image/x-windows-bmp' 
				),
				'boo' => 'application/book',
				'book' => 'application/book',
				'box' => 'application/vnd.previewsystems.box',
				'boz' => 'application/x-bzip2',
				'bpk' => 'application/octet-stream',
				'bsh' => 'application/x-bsh',
				'btf' => 'image/prs.btif',
				'btif' => 'image/prs.btif',
				'bz' => 'application/x-bzip',
				'bz2' => 'application/x-bzip2',
				'c' => array (
						0 => 'text/plain',
						1 => 'text/x-c' 
				),
				'c++' => 'text/plain',
				'cal' => 'image/x-cals',
				'cat' => 'application/vnd.ms-pki.seccat',
				'cc' => array (
						0 => 'text/plain',
						1 => 'text/x-c' 
				),
				'ccad' => 'application/clariscad',
				'ccn' => 'application/x-cnc',
				'cco' => 'application/x-cocoa',
				'cdf' => array (
						0 => 'application/cdf',
						1 => 'application/x-cdf',
						2 => 'application/x-netcdf' 
				),
				'cdkey' => 'application/vnd.mediastation.cdkey',
				'cdx' => array (
						0 => 'chemical/x-cdx',
						1 => 'chemical/x-chem3d' 
				),
				'cer' => array (
						0 => 'application/pkix-cert',
						1 => 'application/x-x509-ca-cert' 
				),
				'cgi' => 'magnus-internal/cgi',
				'cgm' => 'image/cgm',
				'cha' => 'application/x-chat',
				'chat' => 'application/x-chat',
				'chm' => array (
						0 => 'chemical/x-chemdraw',
						1 => 'chemical/x-cs-chemdraw' 
				),
				'cif' => 'chemical/x-cif',
				'cii' => 'application/vnd.anser-web-certificate-issue-initiation',
				'cla' => 'application/vnd.claymore',
				'class' => array (
						0 => 'application/java',
						1 => 'application/java-byte-code',
						2 => 'application/octet-stream',
						3 => 'application/x-java-class',
						4 => 'application/x-java.vm' 
				),
				'clp' => 'application/x-msclip',
				'cmc' => 'application/vnd.cosmocaller',
				'cmdf' => 'chemical/x-cmdf',
				'cml' => 'chemical/x-cml',
				'cmp' => 'application/vnd.yellowriver-custom-menu',
				'cmx' => array (
						0 => 'application/x-cmx',
						1 => 'image/x-cmx' 
				),
				'co' => 'application/x-cult3d-object',
				'cod' => 'image/cis-cod',
				'com' => array (
						0 => 'application/octet-stream',
						1 => 'text/plain' 
				),
				'conf' => 'text/plain',
				'config' => 'application/x-ns-proxy-autoconfig',
				'cpio' => 'application/x-cpio',
				'cpp' => 'text/x-c',
				'cpt' => array (
						0 => 'application/mac-compactpro',
						1 => 'application/x-compactpro',
						2 => 'application/x-cpt' 
				),
				'crd' => 'application/x-mscardfile',
				'crl' => array (
						0 => 'application/pkcs-crl',
						1 => 'application/pkix-crl' 
				),
				'crt' => array (
						0 => 'application/pkix-cert',
						1 => 'application/x-x509-ca-cert',
						2 => 'application/x-x509-user-cert' 
				),
				'csh' => array (
						0 => 'application/x-csh',
						1 => 'text/x-script.csh' 
				),
				'csm' => 'chemical/x-csml',
				'csml' => 'chemical/x-csml',
				'csp' => 'application/vnd.commonspace',
				'css' => array (
						0 => 'application/x-pointplus',
						1 => 'text/css' 
				),
				'cst' => 'application/vnd.commonspace',
				'cub' => 'chemical/x-gaussian-cube',
				'cur' => 'application/octet-stream',
				'curl' => 'text/vnd.curl',
				'cw' => 'application/prs.cww',
				'cww' => 'application/prs.cww',
				'cxx' => 'text/plain',
				'daf' => 'application/vnd.Mobius.DAF',
				'dcm' => 'x-lml/x-evm',
				'dcr' => 'application/x-director',
				'dcx' => 'image/x-dcx',
				'ddd' => 'application/vnd.fujixerox.ddd',
				'deepv' => 'application/x-deepv',
				'def' => 'text/plain',
				'der' => array (
						0 => 'application/pkix-cert',
						1 => 'application/x-x509-ca-cert' 
				),
				'dhtml' => 'text/html',
				'dib' => 'image/bmp',
				'dic' => 'text/plain',
				'dif' => 'video/x-dv',
				'dir' => 'application/x-director',
				'dis' => 'application/vnd.Mobius.DIS',
				'dl' => array (
						0 => 'video/dl',
						1 => 'video/x-dl' 
				),
				'dll' => array (
						0 => 'application/octet-stream',
						1 => 'application/x-msdownload' 
				),
				'dmg' => 'application/octet-stream',
				'dms' => 'application/octet-stream',
				'dna' => 'application/vnd.dna',
				'doc' => 'application/msword',
				'docx'=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
				'dor' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'dot' => array (
						0 => 'application/msword',
						1 => 'application/x-dot' 
				),
				'dp' => 'application/commonground',
				'dpg' => 'application/vnd.dpgraph',
				'dpgraph' => 'application/vnd.dpgraph',
				'drw' => 'application/drafting',
				'dsc' => 'text/prs.lines.tag',
				'dtd' => array (
						0 => 'application/xml',
						1 => 'text/xml' 
				),
				'dump' => 'application/octet-stream',
				'dv' => 'video/x-dv',
				'dvi' => 'application/x-dvi',
				'dwf' => array (
						0 => 'drawing/x-dwf',
						1 => 'drawing/x-dwf,//(old)',
						2 => 'model/vnd.dwf' 
				),
				'dwg' => array (
						0 => 'application/acad',
						1 => 'application/autocad',
						2 => 'application/x-autocad',
						3 => 'image/vnd',
						4 => 'image/vnd.dwg',
						5 => 'image/x-dwg' 
				),
				'dx' => 'chemical/x-jcamp-dx',
				'dxf' => array (
						0 => 'application/dxf',
						1 => 'application/x-autocad',
						2 => 'image/vnd.dxf',
						3 => 'image/x-dwg',
						4 => 'image/x-dxf' 
				),
				'dxr' => array (
						0 => 'application/vnd.dxr',
						1 => 'application/x-director' 
				),
				'ebk' => 'application/x-expandedbook',
				'ecelp4800' => 'audio/vnd.nuera.ecelp4800',
				'ecelp7470' => 'audio/vnd.nuera.ecelp7470',
				'edm' => 'application/vnd.novadigm.EDM',
				'edx' => 'application/vnd.novadigm.EDX',
				'ei6' => 'application/vnd.pg.osasli',
				'el' => 'text/x-script.elisp',
				'elc' => array (
						0 => 'application/x-bytecode.elisp',
						1 => 'application/x-elc' 
				),
				'emb' => 'chemical/x-embl-dl-nucleotide',
				'embl' => 'chemical/x-embl-dl-nucleotide',
				'eml' => 'message/rfc822',
				'enc' => 'video/mpeg',
				'env' => 'application/x-envoy',
				'eol' => 'audio/vnd.digital-winds',
				'epb' => 'application/x-epublisher',
				'eps' => 'application/postscript',
				'eri' => 'image/x-eri',
				'es' => array (
						0 => 'application/x-esrehber',
						1 => 'audio/echospeech' 
				),
				'esl' => 'audio/echospeech',
				'etc' => 'application/x-earthtime',
				'etx' => 'text/x-setext',
				'evm' => 'x-lml/x-evm',
				'evy' => array (
						0 => 'application/envoy',
						1 => 'application/x-envoy' 
				),
				'exc' => 'text/plain',
				'exe' => array (
						0 => 'application/octet-stream',
						1 => 'application/x-msdownload' 
				),
				'ext' => 'application/vnd.novadigm.EXT',
				'ez' => 'application/andrew-inset',
				'f' => array (
						0 => 'text/plain',
						1 => 'text/x-fortran' 
				),
				'f77' => 'text/x-fortran',
				'f90' => array (
						0 => 'text/plain',
						1 => 'text/x-fortran' 
				),
				'faxmgr' => 'application/x-fax-manager',
				'faxmgrjob' => 'application/x-fax-manager-job',
				'fbs' => 'image/vnd.fastbidsheet',
				'fdf' => 'application/vnd.fdf',
				'fdml' => 'text/html',
				'fg5' => 'application/vnd.fujitsu.oasysgp',
				'fgd' => 'application/x-director',
				'fh' => 'image/x-freehand',
				'fh4' => 'image/x-freehand',
				'fh5' => 'image/x-freehand',
				'fh7' => 'image/x-freehand',
				'fhc' => 'image/x-freehand',
				'fif' => array (
						0 => 'application/fractals',
						1 => 'image/fif' 
				),
				'fli' => array (
						0 => 'video/fli',
						1 => 'video/x-fli' 
				),
				'flo' => 'image/florian',
				'flr' => 'x-world/x-vrml',
				'flx' => array (
						0 => 'text/html',
						1 => 'text/vnd.fmi.flexstor' 
				),
				'fly' => 'text/vnd.fly',
				'fm' => array (
						0 => 'application/x-framemaker',
						1 => 'application/x-maker' 
				),
				'fmf' => 'video/x-atomic3d-feature',
				'fml' => array (
						0 => 'application/file-mirror-list',
						1 => 'application/x-file-mirror-list' 
				),
				'for' => array (
						0 => 'text/plain',
						1 => 'text/x-fortran' 
				),
				'fp5' => 'application/filemaker5',
				'fpx' => array (
						0 => 'application/vnd.netfpx',
						1 => 'image/vnd.fpx',
						2 => 'image/vnd.net-fpx',
						3 => 'image/x-fpx' 
				),
				'frame' => 'application/x-framemaker',
				'frl' => 'application/freeloader',
				'frm' => array (
						0 => 'application/vnd.ufdl',
						1 => 'application/vnd.xfdl',
						2 => 'application/x-framemaker' 
				),
				'fst' => 'image/vnd.fst',
				'fti' => 'application/vnd.anser-web-funds-transfer-initiation',
				'funk' => 'audio/make',
				'fvi' => 'video/isivideo',
				'fvt' => 'video/vnd.fvt',
				'g' => 'text/plain',
				'g3' => 'image/g3fax',
				'gac' => 'application/vnd.groove-account',
				'gau' => 'chemical/x-gaussian-input',
				'gca' => 'application/x-gca-compressed',
				'gdb' => 'x-lml/x-gdb',
				'gdl' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'gif' => 'image/gif',
				'gim' => 'application/vnd.groove-identity-message',
				'gl' => array (
						0 => 'video/gl',
						1 => 'video/x-gl' 
				),
				'gph' => 'application/vnd.FloGraphIt',
				'gps' => 'application/x-gps',
				'gqf' => 'application/vnd.grafeq',
				'gqs' => 'application/vnd.grafeq',
				'grv' => 'application/vnd.groove-injector',
				'gsd' => 'audio/x-gsm',
				'gsm' => array (
						0 => 'audio/x-gsm',
						1 => 'model/vnd.gdl',
						2 => 'model/vnd.gs.gdl' 
				),
				'gsp' => 'application/x-gsp',
				'gss' => 'application/x-gss',
				'gtar' => 'application/x-gtar',
				'gtm' => array (
						0 => 'application/vnd.froove-tool-message',
						1 => 'application/vnd.groove-tool-message' 
				),
				'gtp' => 'application/bsi-gtp',
				'gtw' => 'model/vnd.gtw',
				'gz' => array (
						0 => 'application/x-compressed',
						1 => 'application/x-gzip' 
				),
				'gzip' => array (
						0 => 'application/x-gzip',
						1 => 'multipart/x-gzip' 
				),
				'h' => array (
						0 => 'text/plain',
						1 => 'text/x-h' 
				),
				'hdf' => 'application/x-hdf',
				'hdm' => 'text/x-hdml',
				'hdml' => 'text/x-hdml',
				'help' => 'application/x-helpfile',
				'hgl' => 'application/vnd.hp-HPGL',
				'hh' => array (
						0 => 'text/plain',
						1 => 'text/x-h' 
				),
				'hlb' => 'text/x-script',
				'hlp' => array (
						0 => 'application/hlp',
						1 => 'application/winhlp',
						2 => 'application/x-helpfile',
						3 => 'application/x-winhelp' 
				),
				'hpg' => 'application/vnd.hp-HPGL',
				'hpgl' => 'application/vnd.hp-HPGL',
				'hpi' => 'application/vnd.hp-hpid',
				'hpid' => 'application/vnd.hp-hpid',
				'hps' => 'application/vnd.hp-hps',
				'hqx' => array (
						0 => 'application/binhex',
						1 => 'application/binhex4',
						2 => 'application/mac-binhex',
						3 => 'application/mac-binhex40',
						4 => 'application/x-binhex40',
						5 => 'application/x-mac-binhex40' 
				),
				'hta' => 'application/hta',
				'htc' => 'text/x-component',
				'htm' => 'text/html',
				'html' => 'text/html',
				'htmls' => 'text/html',
				'hts' => 'text/html',
				'htt' => 'text/webviewhtml',
				'htx' => 'text/html',
				'ic0' => 'application/vnd.commerce-battelle',
				'ic1' => 'application/vnd.commerce-battelle',
				'ic2' => 'application/vnd.commerce-battelle',
				'ic3' => 'application/vnd.commerce-battelle',
				'ic4' => 'application/vnd.commerce-battelle',
				'ic5' => 'application/vnd.commerce-battelle',
				'ic6' => 'application/vnd.commerce-battelle',
				'ic7' => 'application/vnd.commerce-battelle',
				'ic8' => 'application/vnd.commerce-battelle',
				'ica' => 'application/vnd.commerce-battelle',
				'icc' => 'application/vnd.commerce-battelle',
				'icd' => 'application/vnd.commerce-battelle',
				'ice' => 'x-conference/x-cooltalk',
				'icf' => 'application/vnd.commerce-battelle',
				'ico' => array (
						0 => 'application/octet-stream',
						1 => 'image/x-icon' 
				),
				'idc' => 'text/plain',
				'ief' => 'image/ief',
				'iefs' => 'image/ief',
				'ifm' => array (
						0 => 'application/vnd.shana.informed.formdata',
						1 => 'image/gif' 
				),
				'ifs' => 'image/ifs',
				'iges' => array (
						0 => 'application/iges',
						1 => 'model/iges' 
				),
				'igs' => array (
						0 => 'application/iges',
						1 => 'model/iges' 
				),
				'iif' => 'application/vnd.shana.informed.interchange',
				'iii' => 'application/x-iphone',
				'ima' => 'application/x-ima',
				'imap' => 'application/x-httpd-imap',
				'imd' => 'application/immedia',
				'imp' => 'application/vnd.accpac.simply.imp',
				'ims' => 'application/immedia',
				'imy' => 'audio/melody',
				'inf' => 'application/inf',
				'ins' => array (
						0 => 'application/x-NET-Install',
						1 => 'application/x-insight',
						2 => 'application/x-internet-signup',
						3 => 'application/x-internett-signup' 
				),
				'insight' => 'application/x-insight',
				'inst' => 'application/x-install',
				'ip' => 'application/x-ip2',
				'ipk' => 'application/vnd.shana.informed.package',
				'ips' => 'application/x-ipscript',
				'ipx' => 'application/x-ipix',
				'ism' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'isp' => 'application/x-internet-signup',
				'ist' => 'chemical/x-isostar',
				'istr' => 'chemical/x-isostar',
				'isu' => 'video/x-isvideo',
				'it' => array (
						0 => 'audio/it',
						1 => 'audio/x-mod' 
				),
				'itp' => 'application/vnd.shana.informed.formtemp',
				'itz' => 'audio/x-mod',
				'iv' => 'application/x-inventor',
				'ivf' => 'video/x-ivf',
				'ivr' => array (
						0 => 'i-world/I-vrml',
						1 => 'i-world/i-vrml' 
				),
				'ivy' => 'application/x-livescreen',
				'j2k' => 'image/j2k',
				'jad' => 'text/vnd.sun.j2me.app-descriptor',
				'jam' => array (
						0 => 'application/x-jam',
						1 => 'audio/x-jam' 
				),
				'jar' => array (
						0 => 'application/java-archive',
						1 => 'application/x-java-archive' 
				),
				'jav' => array (
						0 => 'text/plain',
						1 => 'text/x-java-source' 
				),
				'java' => array (
						0 => 'text/plain',
						1 => 'text/x-java-source' 
				),
				'jcm' => 'application/x-java-commerce',
				'jdx' => 'chemical/x-jcamp-dx',
				'jfif' => array (
						0 => 'image/jpeg',
						1 => 'image/pjpeg' 
				),
				'jfif-tbnl' => 'image/jpeg',
				'jnlp' => 'application/x-java-jnlp-file',
				'jpe' => array (
						0 => 'image/jpeg',
						1 => 'image/pjpeg' 
				),
				'jpeg' => array (
						0 => 'image/jpeg',
						1 => 'image/pjpeg' 
				),
				'jpg' => array (
						0 => 'image/jpeg',
						1 => 'image/pjpeg' 
				),
				'jps' => 'image/x-jps',
				'jpz' => 'image/jpeg',
				'js' => array (
						0 => 'application/x-javascript',
						1 => 'application/x-ns-proxy-autoconfig' 
				),
				'jut' => 'image/jutvision',
				'jvs' => 'application/x-ns-proxy-autoconfig',
				'jwc' => 'application/jwc',
				'kar' => array (
						0 => 'audio/midi',
						1 => 'music/x-karaoke' 
				),
				'kin' => 'chemical/x-kinemage',
				'kjx' => 'application/x-kjx',
				'ksh' => array (
						0 => 'application/x-ksh',
						1 => 'text/x-script.ksh' 
				),
				'la' => array (
						0 => 'audio/nspaudio',
						1 => 'audio/x-nspaudio' 
				),
				'lak' => 'x-lml/x-lak',
				'lam' => 'audio/x-liveaudio',
				'latex' => 'application/x-latex',
				'lcc' => 'application/fastman',
				'lcl' => 'application/x-digitalloca',
				'lcr' => 'application/x-digitalloca',
				'lgh' => 'application/lgh',
				'lha' => array (
						0 => 'application/lha',
						1 => 'application/octet-stream',
						2 => 'application/x-lha' 
				),
				'lhx' => 'application/octet-stream',
				'lic' => 'application/x-enterlicense',
				'licmgr' => 'application/x-licensemgr',
				'list' => 'text/plain',
				'list3820' => 'application/vnd.ibm.modcap',
				'listafp' => 'application/vnd.ibm.modcap',
				'lma' => array (
						0 => 'audio/nspaudio',
						1 => 'audio/x-nspaudio' 
				),
				'lml' => 'x-lml/x-lml',
				'lmlpack' => 'x-lml/x-lmlpack',
				'lmp' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'log' => 'text/plain',
				'lsf' => array (
						0 => 'video/x-la-asf',
						1 => 'video/x-ms-asf' 
				),
				'lsp' => array (
						0 => 'application/x-lisp',
						1 => 'text/x-script.lisp' 
				),
				'lst' => 'text/plain',
				'lsx' => array (
						0 => 'text/x-la-asf',
						1 => 'video/x-la-asf',
						2 => 'video/x-ms-asf' 
				),
				'ltx' => 'application/x-latex',
				'lvp' => 'audio/vnd.lucent.voice',
				'lwp' => 'application/vnd.lotus-wordpro',
				'lzh' => array (
						0 => 'application/octet-stream',
						1 => 'application/x-lzh' 
				),
				'lzx' => array (
						0 => 'application/lzx',
						1 => 'application/octet-stream',
						2 => 'application/x-lzx' 
				),
				'm' => array (
						0 => 'text/plain',
						1 => 'text/x-m' 
				),
				'm13' => 'application/x-msmediaview',
				'm14' => 'application/x-msmediaview',
				'm15' => 'audio/x-mod',
				'm1v' => 'video/mpeg',
				'm2a' => 'audio/mpeg',
				'm2v' => 'video/mpeg',
				'm3a' => 'audio/mpeg',
				'm3u' => array (
						0 => 'audio/mpegurl',
						1 => 'audio/x-mpegurl',
						2 => 'audio/x-mpequrl',
						3 => 'audio/x-scpls',
						4 => 'uadio/scpls' 
				),
				'm3url' => 'audio/x-mpegurl',
				'ma' => array (
						0 => 'application/mathematica',
						1 => 'application/mathematica-old' 
				),
				'ma1' => 'audio/ma1',
				'ma2' => 'audio/ma2',
				'ma3' => 'audio/ma3',
				'ma5' => 'audio/ma5',
				'mag' => 'application/vnd.ecowin.chart',
				'mail' => 'application/x-mailfolder',
				'maker' => 'application/x-framemaker',
				'man' => 'application/x-troff-man',
				'map' => array (
						0 => 'application/x-navimap',
						1 => 'magnus-internal/imagemap' 
				),
				'mar' => 'text/plain',
				'mb' => array (
						0 => 'application/mathematica',
						1 => 'application/mathematica-old' 
				),
				'mbd' => 'application/mbedlet',
				'mbm' => 'image/x-epoc-mbm',
				'mc$' => 'application/x-magic-cap-package-1.0',
				'mcd' => array (
						0 => 'application/mcad',
						1 => 'application/vnd.mcd',
						2 => 'application/vnd.vectorworks',
						3 => 'application/x-mathcad' 
				),
				'mcf' => array (
						0 => 'image/vasa',
						1 => 'text/mcf' 
				),
				'mcm' => 'chemical/x-macmolecule',
				'mcp' => 'application/netmc',
				'mct' => 'application/x-mascot',
				'mdb' => array (
						0 => 'application/msaccess',
						1 => 'application/x-msaccess' 
				),
				'mdz' => 'audio/x-mod',
				'me' => 'application/x-troff-me',
				'med' => 'application/x-att-a2bmusic-pu',
				'mel' => 'text/x-vmel',
				'mes' => 'application/x-att-a2bmusic',
				'mesh' => 'model/mesh',
				'mht' => 'message/rfc822',
				'mhtml' => 'message/rfc822',
				'mi' => 'application/x-mif',
				'mid' => array (
						0 => 'application/x-midi',
						1 => 'audio/mid',
						2 => 'audio/midi',
						3 => 'audio/x-mid',
						4 => 'audio/x-midi',
						5 => 'music/crescendo',
						6 => 'x-music/x-midi' 
				),
				'midi' => array (
						0 => 'application/x-midi',
						1 => 'audio/midi',
						2 => 'audio/x-mid',
						3 => 'audio/x-midi',
						4 => 'music/crescendo',
						5 => 'x-music/x-midi' 
				),
				'mif' => array (
						0 => 'application/vnd.mif',
						1 => 'application/x-frame',
						2 => 'application/x-mif' 
				),
				'mil' => 'image/x-cals',
				'mime' => array (
						0 => 'message/rfc822',
						1 => 'www/mime' 
				),
				'mio' => 'audio/x-mio',
				'mjf' => 'audio/x-vnd.AudioExplosion.MjuiceMediaFile',
				'mjpg' => 'video/x-motion-jpeg',
				'ml5' => 'application/ml5',
				'mm' => array (
						0 => 'application/base64',
						1 => 'application/x-meme' 
				),
				'mmd' => array (
						0 => 'chemical/x-macromodel',
						1 => 'chemical/x-macromodel-input' 
				),
				'mme' => 'application/base64',
				'mmf' => 'application/x-skt-lbs',
				'mmod' => 'chemical/x-macromodel-input',
				'mmr' => 'image/vnd.fujixerox.edmics-mmr',
				'mng' => 'video/x-mng',
				'mny' => 'application/x-msmoney',
				'moc' => 'application/x-mocha',
				'mocha' => 'application/x-mocha',
				'mod' => array (
						0 => 'audio/mod',
						1 => 'audio/x-mod' 
				),
				'mof' => 'application/x-yumekara',
				'mol' => 'chemical/x-mdl-molfile',
				'moov' => 'video/quicktime',
				'mop' => 'chemical/x-mopac-input',
				'mov' => 'video/quicktime',
				'movie' => 'video/x-sgi-movie',
				'mp2' => array (
						0 => 'audio/mpeg',
						1 => 'audio/x-mpeg',
						2 => 'video/mpeg',
						3 => 'video/x-mpeg',
						4 => 'video/x-mpeg2a',
						5 => 'video/x-mpeq2a' 
				),
				'mp2a' => 'audio/x-mpeg2',
				'mp2v' => 'video/x-mpeg2',
				'mp3' => array (
						0 => 'audio/mp3',
						1 => 'audio/mpeg',
						2 => 'audio/mpeg3',
						3 => 'audio/mpg',
						4 => 'audio/x-mpeg',
						5 => 'audio/x-mpeg-3',
						6 => 'video/mpeg',
						7 => 'video/x-mpeg' 
				),
				'mp3url' => 'audio/x-mpegurl',
				'mp4' => 'video/mp4',
				'mpa' => array (
						0 => 'audio/mpeg',
						1 => 'video/mpeg' 
				),
				'mpa2' => 'audio/x-mpeg2',
				'mpc' => array (
						0 => 'application/vnd.mpohun.certificate',
						1 => 'application/x-project' 
				),
				'mpd' => 'application/vnd.ms-project',
				'mpe' => 'video/mpeg',
				'mpeg' => 'video/mpeg',
				'mpf' => array (
						0 => 'text/vnd-mediapackage',
						1 => 'text/vnd.ms-mediapackage' 
				),
				'mpg' => array (
						0 => 'audio/mpeg',
						1 => 'video/mpeg' 
				),
				'mpg4' => 'video/mp4',
				'mpga' => 'audio/mpeg',
				'mpn' => 'application/vnd.mophun.application',
				'mpp' => 'application/vnd.ms-project',
				'mps' => array (
						0 => 'application/x-mapserver',
						1 => 'video/x-mpeg-system' 
				),
				'mpt' => array (
						0 => 'application/vnd.ms-project',
						1 => 'application/x-project' 
				),
				'mpv' => array (
						0 => 'application/x-project',
						1 => 'video/mpeg' 
				),
				'mpv2' => array (
						0 => 'video/mpeg',
						1 => 'video/x-mpeg2' 
				),
				'mpx' => 'application/x-project',
				'mpy' => 'application/vnd.ibm.MiniPay',
				'mrc' => 'application/marc',
				'mrl' => 'text/x-mrml',
				'mrm' => 'application/x-mrm',
				'ms' => 'application/x-troff-ms',
				'msf' => 'application/vnd.epson.msf',
				'msh' => 'model/mesh',
				'msl' => 'application/vnd.Mobius.MSL',
				'msm' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'mss' => 'audio/mss',
				'msv' => 'application/x-mystars-view',
				'mts' => array (
						0 => 'application/metastream',
						1 => 'model/vnd.mts' 
				),
				'mtx' => 'application/metastream',
				'mtz' => 'application/metastream',
				'mus' => 'application/vnd.musician',
				'mv' => 'video/x-sgi-movie',
				'mvb' => 'application/x-msmediaview',
				'mwc' => 'application/vnd.dpgraph',
				'mxs' => 'application/vnd.triscape.mxs',
				'my' => 'audio/make',
				'mzv' => 'application/metastream',
				'mzz' => 'application/x-vnd.AudioExplosion.mzz',
				'nap' => 'image/naplps',
				'naplps' => 'image/naplps',
				'nar' => 'application/zip',
				'nb' => 'application/mathematica',
				'nbmp' => 'image/nbmp',
				'nc' => 'application/x-netcdf',
				'nclk' => 'text/html',
				'ncm' => 'application/vnd.nokia.configuration-message',
				'ndb' => 'x-lml/x-ndb',
				'ndl' => 'application/vnd.lotus-notes',
				'ndwn' => 'application/ndwn',
				'nif' => array (
						0 => 'application/x-nif',
						1 => 'image/x-niff' 
				),
				'niff' => 'image/x-niff',
				'nix' => 'application/x-mix-transfer',
				'nls' => 'text/nls',
				'nml' => 'application/vnd.enliven',
				'nmz' => 'application/x-scream',
				'nnd' => 'application/vnd.noblenet-directory',
				'nns' => 'application/vnd.noblenet-sealer',
				'nnw' => 'application/vnd.noblenet-web',
				'nokia-op-logo' => 'image/vnd.nok-oplogo-color',
				'npx' => 'application/x-netfpx',
				'ns2' => 'application/vnd.lotus-notes',
				'ns3' => 'application/vnd.lotus-notes',
				'ns4' => 'application/vnd.lotus-notes',
				'nsc' => 'application/x-conference',
				'nsf' => 'application/vnd.lotus-notes',
				'nsg' => 'application/vnd.lotus-notes',
				'nsh' => 'application/vnd.lotus-notes',
				'nsnd' => 'audio/nsnd',
				'ntf' => 'application/vnd.lotus-notes',
				'nva' => 'application/x-neva1',
				'nvd' => 'application/x-navidoc',
				'nvm' => 'application/x-navimap',
				'nws' => 'message/rfc822',
				'o' => 'application/octet-stream',
				'oa2' => 'application/vnd.fujitsu.oasys2',
				'oa3' => 'application/vnd.fujitsu.oasys3',
				'oas' => 'application/vnd.fujitsu.oasys',
				'obd' => 'application/x-msbinder',
				'oda' => 'application/oda',
				'omc' => 'application/x-omc',
				'omcd' => 'application/x-omcdatamaker',
				'omcr' => 'application/x-omcregerator',
				'oom' => 'application/x-AtlasMate-Plugin',
				'or2' => 'application/vnd.lotus-organizer',
				'or3' => 'application/vnd.lotus-organizer',
				'org' => 'application/vnd.lotus-organizer',
				'orq' => 'application/ocsp-request',
				'ors' => 'application/ocsp-response',
				'ota' => 'image/x-ota-bitmap',
				'p' => 'text/x-pascal',
				'p10' => array (
						0 => 'application/pkcs10',
						1 => 'application/x-pkcs10' 
				),
				'p12' => array (
						0 => 'application/pkcs-12',
						1 => 'application/x-pkcs12' 
				),
				'p7a' => 'application/x-pkcs7-signature',
				'p7b' => 'application/x-pkcs7-certificates',
				'p7c' => array (
						0 => 'application/pkcs7-mime',
						1 => 'application/x-pkcs7-mime' 
				),
				'p7m' => array (
						0 => 'application/pkcs7-mime',
						1 => 'application/x-pkcs7-mime' 
				),
				'p7r' => 'application/x-pkcs7-certreqresp',
				'p7s' => 'application/pkcs7-signature',
				'pac' => array (
						0 => 'application/x-ns-proxy-autoconfig',
						1 => 'audio/x-pac' 
				),
				'pae' => 'audio/x-epac',
				'pan' => 'application/x-pan',
				'part' => 'application/pro_eng',
				'pas' => 'text/pascal',
				'pat' => 'audio/x-pat',
				'pbd' => array (
						0 => 'application/vnd.powerbuilder6',
						1 => 'application/vnd.powerbuilder6-s',
						2 => 'application/vnd.powerbuilder7',
						3 => 'application/vnd.powerbuilder7-s',
						4 => 'application/vnd.powerbuilder75',
						5 => 'application/vnd.powerbuilder75-s' 
				),
				'pbm' => 'image/x-portable-bitmap',
				'pcd' => 'image/x-photo-cd',
				'pcl' => array (
						0 => 'application/vnd.hp-PCL',
						1 => 'application/x-pcl' 
				),
				'pct' => 'image/x-pict',
				'pcx' => 'image/x-pcx',
				'pda' => 'image/x-pda',
				'pdb' => 'chemical/x-pdb',
				'pdf' => 'application/pdf',
				'pfr' => 'application/font-tdpfr',
				'pfunk' => array (
						0 => 'audio/make',
						1 => 'audio/make.my.funk' 
				),
				'pfx' => 'application/x-pkcs12',
				'pgm' => array (
						0 => 'image/x-portable-graymap',
						1 => 'image/x-portable-greymap' 
				),
				'pgn' => 'application/x-chess-pgn',
				'pgp' => 'application/pgp-encrypted',
				'pic' => 'image/pict',
				'pict' => array (
						0 => 'image/pict',
						1 => 'image/x-pict' 
				),
				'pkg' => 'application/x-newton-compatible-pkg',
				'pki' => 'application/pkixcmp',
				'pko' => 'application/vnd.ms-pki.pko',
				'pl' => array (
						0 => 'text/plain',
						1 => 'text/x-script.perl' 
				),
				'plc' => 'application/vnd.Mobius.PLC',
				'plg' => 'text/html',
				'plj' => 'audio/vnd.everad.plj',
				'pls' => array (
						0 => 'audio/mpegurl',
						1 => 'audio/scpls',
						2 => 'audio/x-mpequrl',
						3 => 'audio/x-scpls',
						4 => 'uadio/scpls' 
				),
				'plx' => 'application/x-PiXCLscript',
				'pm' => array (
						0 => 'application/x-perl',
						1 => 'image/x-xpixmap',
						2 => 'text/x-script.perl-module' 
				),
				'pm4' => 'application/x-pagemaker',
				'pm5' => 'application/x-pagemaker',
				'pma' => 'application/x-perfmon',
				'pmc' => 'application/x-perfmon',
				'pmd' => 'application/x-pmd',
				'pml' => array (
						0 => 'application/vnd.ctc-posml',
						1 => 'application/x-perfmon' 
				),
				'pmr' => 'application/x-perfmon',
				'pmw' => 'application/x-perfmon',
				'png' => array (
						0 => 'image/png',
						1 => 'image/x-png' 
				),
				'pnm' => array (
						0 => 'application/x-portable-anymap',
						1 => 'image/x-portable-anymap' 
				),
				'pnz' => 'image/png',
				'pot' => array (
						0 => 'application/mspowerpoint',
						1 => 'application/vnd.ms-powerpoint' 
				),
				'pov' => 'model/x-pov',
				'ppa' => 'application/vnd.ms-powerpoint',
				'ppm' => 'image/x-portable-pixmap',
				'pps' => array (
						0 => 'application/mspowerpoint',
						1 => 'application/vnd.ms-powerpoint' 
				),
				'ppt' => array (
						0 => 'application/mspowerpoint',
						1 => 'application/powerpoint',
						2 => 'application/vnd.ms-powerpoint',
						3 => 'application/x-mspowerpoint' 
				),
				'pptx'=>'application/vnd.openxmlformats-officedocument.presentationml.presentation',
				'ppz' => array (
						0 => 'application/mspowerpoint',
						1 => 'application/ppt' 
				),
				'pqf' => 'application/x-cprplayer',
				'pqi' => 'application/cprplayer',
				'prc' => 'application/x-prc',
				'pre' => array (
						0 => 'application/vnd.lotus-freelance',
						1 => 'application/x-freelance' 
				),
				'prf' => 'application/pics-rules',
				'proxy' => 'application/x-ns-proxy-autoconfig',
				'prt' => 'application/pro_eng',
				'prz' => 'application/vnd.lotus-freelance',
				'ps' => 'application/postscript',
				'psd' => 'application/octet-stream',
				'pseg3820' => 'application/vnd.ibm.modcap',
				'psid' => 'audio/prs.sid',
				'pti' => 'image/prs.pti',
				'ptlk' => 'application/listenup',
				'pub' => 'application/x-mspublisher',
				'puz' => 'application/x-crossword',
				'pvu' => 'paleovu/x-pv',
				'pvx' => 'video/x-pv-pvx',
				'pwn' => 'application/vnd.3M.Post-it-Notes',
				'pwz' => 'application/vnd.ms-powerpoint',
				'py' => 'text/x-script.phyton',
				'pyc' => 'applicaiton/x-bytecode.python',
				'qam' => 'application/vnd.epson.quickanime',
				'qbo' => 'application/vnd.intu.qbo',
				'qca' => 'application/vnd.ericsson.quickcall',
				'qcall' => 'application/vnd.ericsson.quickcall',
				'qcp' => 'audio/vnd.qcelp',
				'qd3' => 'x-world/x-3dmf',
				'qd3d' => 'x-world/x-3dmf',
				'qfx' => 'application/vnd.intu.qfx',
				'qif' => 'image/x-quicktime',
				'qps' => 'application/vnd.publishare-delta-tree',
				'qry' => 'text/html',
				'qt' => 'video/quicktime',
				'qtc' => 'video/x-qtc',
				'qti' => 'image/x-quicktime',
				'qtif' => 'image/x-quicktime',
				'qtvr' => 'video/quicktime',
				'r3t' => 'text/vnd.rn-realtext3d',
				'ra' => array (
						0 => 'application/x-pn-realaudio',
						1 => 'audio/vnd.rn-realaudio',
						2 => 'audio/x-pn-realaudio',
						3 => 'audio/x-pn-realaudio-plugin',
						4 => 'audio/x-realaudio' 
				),
				'ram' => array (
						0 => 'application/x-pn-realaudio',
						1 => 'audio/x-pn-realaudio',
						2 => 'audio/x-pn-realaudio-plugin' 
				),
				'rar' => array (
						0 => 'application/rar',
						1 => 'application/x-rar-compressed' 
				),
				'ras' => array (
						0 => 'application/x-cmu-raster',
						1 => 'image/cmu-raster',
						2 => 'image/x-cmu-raster' 
				),
				'rast' => 'image/cmu-raster',
				'rb' => 'application/x-rocketbook',
				'rct' => 'application/prs.nprend',
				'rdf' => 'application/rdf+xml',
				'rep' => 'application/vnd.businessobjects',
				'rexx' => 'text/x-script.rexx',
				'rf' => 'image/vnd.rn-realflash',
				'rgb' => 'image/x-rgb',
				'rjs' => 'application/vnd.rn-realsystem-rjs',
				'rlc' => 'image/vnd.fujixerox.edmics-rlc',
				'rlf' => 'application/x-richlink',
				'rm' => array (
						0 => 'application/vnd.rn-realmedia',
						1 => 'application/x-pn-realaudio',
						2 => 'audio/x-pn-realaudio',
						3 => 'audio/x-pn-realaudio-plugin' 
				),
				'rmf' => 'audio/x-rmf',
				'rmi' => 'audio/mid',
				'rmm' => 'audio/x-pn-realaudio',
				'rmp' => array (
						0 => 'application/vnd.rn-rn_music_package',
						1 => 'audio/x-pn-realaudio',
						2 => 'audio/x-pn-realaudio-plugin' 
				),
				'rmvb' => 'audio/x-pn-realaudio',
				'rmx' => 'application/vnd.rn-realsystem-rmx',
				'rnd' => 'application/prs.nprend',
				'rng' => array (
						0 => 'application/ringing-tones',
						1 => 'application/vnd.nokia.ringing-tone' 
				),
				'rnx' => 'application/vnd.rn-realplayer',
				'roff' => 'application/x-troff',
				'rp' => 'image/vnd.rn-realpix',
				'rpm' => array (
						0 => 'application/x-pn-realaudio',
						1 => 'audio/x-pn-RealAudio-plugin',
						2 => 'audio/x-pn-realaudio-plugin' 
				),
				'rsm' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'rsml' => 'application/vnd.rn-rsml',
				'rt' => array (
						0 => 'text/richtext',
						1 => 'text/vnd.rn-realtext' 
				),
				'rte' => 'x-lml/x-gps',
				'rtf' => array (
						0 => 'application/msword',
						1 => 'application/rtf',
						2 => 'application/x-rtf',
						3 => 'text/richtext',
						4 => 'text/rtf' 
				),
				'rtg' => 'application/metastream',
				'rts' => 'application/x-rtsl',
				'rtx' => array (
						0 => 'application/rtf',
						1 => 'text/richtext' 
				),
				'rv' => 'video/vnd.rn-realvideo',
				'rwc' => 'application/x-rogerwilco',
				'rxn' => array (
						0 => 'chemical/x-mdl-rxn',
						1 => 'chemical/x-mdl-rxnfile' 
				),
				's' => 'text/x-asm',
				's3m' => array (
						0 => 'audio/s3m',
						1 => 'audio/x-mod' 
				),
				's3z' => 'audio/x-mod',
				'sam' => 'application/vnd.lotus-wordpro',
				'saveme' => 'application/octet-stream',
				'sbk' => array (
						0 => 'application/x-tbook',
						1 => 'audio/x-sbk' 
				),
				'sc' => 'application/x-showcase',
				'sca' => 'application/x-supercard',
				'scd' => 'application/x-msschedule',
				'scm' => array (
						0 => 'application/vnd.lotus-screencam',
						1 => 'application/x-lotusscreencam',
						2 => 'text/x-script.guile',
						3 => 'text/x-script.scheme',
						4 => 'video/x-scm' 
				),
				'scp' => 'text/plain',
				'sct' => 'text/scriptlet',
				'sdf' => array (
						0 => 'application/e-score',
						1 => 'chemical/x-mdl-sdf' 
				),
				'sdml' => 'text/plain',
				'sdp' => array (
						0 => 'application/sdp',
						1 => 'application/x-sdp' 
				),
				'sdr' => 'application/sounder',
				'sds' => 'application/x-onlive',
				'sea' => array (
						0 => 'application/sea',
						1 => 'application/x-sea',
						2 => 'application/x-stuffit' 
				),
				'see' => 'application/vnd.seemail',
				'ser' => 'application/x-java-serialized-object',
				'set' => 'application/set',
				'setpay' => 'application/set-payment-initiation',
				'setreg' => 'application/set-registration-initiation',
				'sgi-lpr' => 'application/x-sgi-lpr',
				'sgm' => array (
						0 => 'text/sgml',
						1 => 'text/x-sgml' 
				),
				'sgml' => array (
						0 => 'text/sgml',
						1 => 'text/x-sgml' 
				),
				'sh' => array (
						0 => 'application/x-bsh',
						1 => 'application/x-sh',
						2 => 'application/x-shar',
						3 => 'text/x-script.sh' 
				),
				'sha' => 'application/x-shar',
				'shar' => array (
						0 => 'application/x-bsh',
						1 => 'application/x-shar' 
				),
				'sho' => 'application/x-showcase',
				'show' => 'application/x-showcase',
				'showcase' => 'application/x-showcase',
				'shtml' => array (
						0 => 'magnus-internal/parsed-html',
						1 => 'text/html',
						2 => 'text/x-server-parsed-html' 
				),
				'shw' => 'application/presentations',
				'si' => 'text/vnd.wap.si',
				'si6' => 'image/si6',
				'si7' => 'image/vnd.stiwap.sis',
				'si9' => 'image/vnd.lgtwap.sis',
				'sic' => 'application/vnd.wap.sic',
				'sid' => array (
						0 => 'audio/prs.sid',
						1 => 'audio/x-psid' 
				),
				'silo' => 'model/mesh',
				'sis' => 'application/vnd.symbian.install',
				'sit' => array (
						0 => 'application/x-sit',
						1 => 'application/x-stuffit' 
				),
				'skc' => 'chemical/x-mdl-isis',
				'skd' => array (
						0 => 'application/vnd.koan',
						1 => 'application/x-Koan',
						2 => 'application/x-koan' 
				),
				'skm' => array (
						0 => 'application/vnd.koan',
						1 => 'application/x-Koan',
						2 => 'application/x-koan' 
				),
				'skp' => array (
						0 => 'application/vnd.koan',
						1 => 'application/x-Koan',
						2 => 'application/x-koan' 
				),
				'skt' => array (
						0 => 'application/vnd.koan',
						1 => 'application/x-Koan',
						2 => 'application/x-koan' 
				),
				'sl' => array (
						0 => 'application/x-seelogo',
						1 => 'text/vnd.wap.sl' 
				),
				'slc' => array (
						0 => 'application/vnd.wap.slc',
						1 => 'application/x-salsa' 
				),
				'slides' => 'application/x-showcase',
				'slt' => 'application/vnd.epson.salt',
				'smd' => array (
						0 => 'audio/x-smd',
						1 => 'chemical/x-smd' 
				),
				'smi' => array (
						0 => 'application/smil',
						1 => 'chemical/x-daylight-smiles',
						2 => 'chemical/x-x-daylight-smiles' 
				),
				'smil' => 'application/smil',
				'smp' => 'application/studiom',
				'smz' => 'audio/x-smd',
				'snd' => array (
						0 => 'audio/basic',
						1 => 'audio/x-adpcm' 
				),
				'sol' => 'application/solids',
				'spc' => array (
						0 => 'application/x-pkcs7-certificates',
						1 => 'chemical/x-galactic-spc',
						2 => 'text/x-speech' 
				),
				'spl' => array (
						0 => 'application/futuresplash',
						1 => 'application/x-futuresplash' 
				),
				'spo' => 'text/vnd.in3d.spot',
				'spot' => 'text/vnd.in3d.spot',
				'spr' => 'application/x-sprite',
				'sprite' => 'application/x-sprite',
				'spt' => 'application/x-spt',
				'src' => 'application/x-wais-source',
				'ssf' => 'application/vnd.epson.ssf',
				'ssi' => 'text/x-server-parsed-html',
				'ssm' => 'application/streamingmedia',
				'sst' => 'application/vnd.ms-pki.certstore',
				'step' => 'application/step',
				'stf' => 'application/vnd.wt.stf',
				'stk' => 'application/hyperstudio',
				'stl' => array (
						0 => 'application/sla',
						1 => 'application/vnd.ms-pki.stl',
						2 => 'application/x-navistyle' 
				),
				'stm' => array (
						0 => 'audio/x-mod',
						1 => 'text/html' 
				),
				'stp' => 'application/step',
				'str' => array (
						0 => 'application/vnd.pg.format',
						1 => 'audio/x-str' 
				),
				'sv4cpio' => 'application/x-sv4cpio',
				'sv4crc' => 'application/x-sv4crc',
				'svf' => array (
						0 => 'image/vnd',
						1 => 'image/vnd.svf',
						2 => 'image/x-dwg' 
				),
				'svg' => 'image/svg-xml',
				'svh' => 'image/svh',
				'svr' => array (
						0 => 'application/x-world',
						1 => 'x-world/x-svr' 
				),
				'swf' => 'application/x-shockwave-flash',
				'swfl' => 'application/x-shockwave-flash',
				'sys' => 'video/x-mpeg-system',
				't' => 'application/x-troff',
				'tad' => 'application/octet-stream',
				'tag' => 'text/prs.lines.tag',
				'talk' => array (
						0 => 'plugin/talker',
						1 => 'text/x-speech',
						2 => 'x-plugin/x-talker' 
				),
				'tar' => 'application/x-tar',
				'tardist' => 'application/x-tardist',
				'taz' => 'application/x-tar',
				'tbk' => array (
						0 => 'application/toolbook',
						1 => 'application/x-tbook' 
				),
				'tbp' => 'application/x-timbuktu',
				'tbt' => array (
						0 => 'application/timbuktu',
						1 => 'application/x-timbuktu' 
				),
				'tcl' => array (
						0 => 'application/x-tcl',
						1 => 'text/x-script.tcl' 
				),
				'tcsh' => 'text/x-script.tcsh',
				'tex' => 'application/x-tex',
				'texi' => array (
						0 => 'application/x-tex',
						1 => 'application/x-texinfo' 
				),
				'texinfo' => 'application/x-texinfo',
				'text' => array (
						0 => 'application/plain',
						1 => 'application/text',
						2 => 'text/plain' 
				),
				'tgf' => 'chemical/x-mdl-tgf',
				'tgz' => array (
						0 => 'application/gnutar',
						1 => 'application/x-compressed',
						2 => 'application/x-tar' 
				),
				'thm' => 'application/vnd.eri.thm',
				'tif' => array (
						0 => 'image/tiff',
						1 => 'image/x-tiff' 
				),
				'tiff' => array (
						0 => 'image/tiff',
						1 => 'image/x-tiff' 
				),
				'tki' => 'application/x-tkined',
				'tkined' => 'application/x-tkined',
				'toc' => 'application/toc',
				'toy' => 'image/toy',
				'tpl' => 'application/vnd.groove-tool-template',
				'tr' => 'application/x-troff',
				'tra' => 'application/vnd.trueapp',
				'trk' => 'x-lml/x-gps',
				'trm' => 'application/x-msterminal',
				'tsi' => array (
						0 => 'audio/tsp-audio',
						1 => 'audio/tsplayer' 
				),
				'tsp' => array (
						0 => 'application/dsptype',
						1 => 'audio/tsplayer' 
				),
				'tsv' => 'text/tab-separated-values',
				'ttf' => 'application/octet-stream',
				'ttz' => 'application/t-time',
				'turbot' => 'image/florian',
				'tvm' => 'application/x-tvml',
				'tvml' => 'application/x-tvml',
				'txf' => 'application/vnd.Mobius.TXF',
				'txt' => array (
						0 => 'application/text',
						1 => 'text/plain' 
				),
				'ufdl' => 'application/vnd.ufdl',
				'uil' => 'text/x-uil',
				'ult' => 'audio/x-mod',
				'uni' => 'text/uri-list',
				'unis' => 'text/uri-list',
				'unv' => 'application/i-deas',
				'uri' => 'text/uri-list',
				'uris' => 'text/uri-list',
				'urls' => 'application/x-url-list',
				'ustar' => array (
						0 => 'application/x-ustar',
						1 => 'multipart/x-ustar' 
				),
				'uu' => array (
						0 => 'application/octet-stream',
						1 => 'application/uue',
						2 => 'application/x-uuencode',
						3 => 'text/x-uuencode' 
				),
				'uue' => array (
						0 => 'application/uue',
						1 => 'application/x-uuencode',
						2 => 'text/x-uuencode' 
				),
				'v5d' => 'application/vis5d',
				'vbk' => 'audio/vnd.nortel.vbk',
				'vbox' => 'application/vnd.previewsystems.box',
				'vbs' => 'text/vbscript',
				'vcd' => 'application/x-cdlink',
				'vcf' => 'text/x-vcard',
				'vcg' => 'application/vnd.groove-vcard',
				'vcs' => 'text/x-vCalendar',
				'vcx' => 'application/vnd.vcx',
				'vda' => 'application/vda',
				'vdo' => 'video/vdo',
				'vew' => array (
						0 => 'application/groupwise',
						1 => 'application/vnd.lotus-approach' 
				),
				'vib' => 'audio/vib',
				'vis' => 'application/vnd.informix-visionary',
				'viv' => array (
						0 => 'video/vivo',
						1 => 'video/vnd.vivo' 
				),
				'vivo' => array (
						0 => 'video/vivo',
						1 => 'video/vnd.vivo' 
				),
				'vmd' => array (
						0 => 'application/vocaltec-media-desc',
						1 => 'chemical/x-vmd' 
				),
				'vmf' => 'application/vocaltec-media-file',
				'vmi' => array (
						0 => 'application/x-dreamcast-vms-info',
						1 => 'application/x-dremacast-vms-info' 
				),
				'vms' => array (
						0 => 'application/x-dreamcast-vms',
						1 => 'application/x-dremacast-vms' 
				),
				'voc' => array (
						0 => 'audio/voc',
						1 => 'audio/x-voc' 
				),
				'vos' => 'video/vosaic',
				'vox' => 'audio/voxware',
				'vqe' => 'audio/x-twinvq-plugin',
				'vqf' => 'audio/x-twinvq',
				'vql' => array (
						0 => 'audio/x-twinvq',
						1 => 'audio/x-twinvq-plugin' 
				),
				'vre' => 'x-world/x-vream',
				'vrj' => 'x-world/x-vrt',
				'vrml' => array (
						0 => 'application/x-vrml',
						1 => 'model/vrml',
						2 => 'x-world/x-vrml' 
				),
				'vrt' => 'x-world/x-vrt',
				'vrw' => 'x-world/x-vream',
				'vsd' => array (
						0 => 'application/vnd.visio',
						1 => 'application/x-visio' 
				),
				'vsl' => 'application/x-cnet-vsl',
				'vss' => 'application/vnd.visio',
				'vst' => array (
						0 => 'application/vnd.visio',
						1 => 'application/x-visio' 
				),
				'vsw' => array (
						0 => 'application/vnd.visio',
						1 => 'application/x-visio' 
				),
				'vts' => 'workbook/formulaone',
				'vtu' => 'model/vnd.vtu',
				'w60' => 'application/wordperfect6.0',
				'w61' => 'application/wordperfect6.1',
				'w6w' => 'application/msword',
				'wav' => array (
						0 => 'application/x-wav',
						1 => 'audio/wav',
						2 => 'audio/x-wav' 
				),
				'wax' => 'audio/x-ms-wax',
				'wb1' => 'application/x-qpro',
				'wbc' => 'application/x-webshots',
				'wbmp' => 'image/vnd.wap.wbmp',
				'wbxml' => array (
						0 => 'application/vnd.wap.sic',
						1 => 'application/vnd.wap.slc',
						2 => 'application/vnd.wap.wbxml',
						3 => 'application/vnd.wap.wmlc' 
				),
				'wcm' => 'application/vnd.ms-works',
				'wdb' => 'application/vnd.ms-works',
				'web' => 'application/vnd.xara',
				'wi' => 'image/wavelet',
				'win' => array (
						0 => 'model/vnd.gdl',
						1 => 'model/vnd.gs.gdl' 
				),
				'wis' => 'application/x-InstallShield',
				'wiz' => 'application/msword',
				'wk1' => array (
						0 => 'application/vnd.lotus-1-2-3',
						1 => 'application/x-123' 
				),
				'wk3' => 'application/vnd.lotus-1-2-3',
				'wk4' => 'application/vnd.lotus-1-2-3',
				'wks' => 'application/vnd.ms-works',
				'wkz' => 'application/x-wingz',
				'wm' => array (
						0 => 'video/x-ms-asf',
						1 => 'video/x-ms-wm' 
				),
				'wma' => 'audio/x-ms-wma',
				'wmd' => 'application/x-ms-wmd',
				'wmf' => array (
						0 => 'application/x-msmetafile',
						1 => 'image/x-wmf',
						2 => 'windows/metafile' 
				),
				'wml' => 'text/vnd.wap.wml',
				'wmlc' => 'application/vnd.wap.wmlc',
				'wmls' => 'text/vnd.wap.wmlscript',
				'wmlsc' => 'application/vnd.wap.wmlscriptc',
				'wmlscript' => 'text/vnd.wap.wmlscript',
				'wmv' => 'video/x-ms-wmv',
				'wmx' => 'video/x-ms-wmx',
				'wmz' => 'application/x-ms-wmz',
				'word' => 'application/msword',
				'wp' => 'application/wordperfect',
				'wp5' => array (
						0 => 'application/wordperfect',
						1 => 'application/wordperfect6.0' 
				),
				'wp6' => 'application/wordperfect',
				'wpd' => array (
						0 => 'application/wordperfect',
						1 => 'application/x-wpwin' 
				),
				'wpng' => 'image/x-up-wpng',
				'wps' => 'application/vnd.ms-works',
				'wpt' => 'x-lml/x-gps',
				'wq1' => 'application/x-lotus',
				'wri' => array (
						0 => 'application/mswrite',
						1 => 'application/x-mswrite',
						2 => 'application/x-wri' 
				),
				'wrl' => array (
						0 => 'application/x-world',
						1 => 'i-world/i-vrml',
						2 => 'model/vrml',
						3 => 'x-world/x-vrml' 
				),
				'wrz' => array (
						0 => 'model/vrml',
						1 => 'x-world/x-vrml' 
				),
				'ws' => 'text/vnd.wap.wmlscript',
				'wsc' => array (
						0 => 'application/vnd.wap.wmlscriptc',
						1 => 'text/scriptlet',
						2 => 'text/sgml' 
				),
				'wsrc' => 'application/x-wais-source',
				'wtb' => 'application/vnd.webturbo',
				'wtk' => 'application/x-wintalk',
				'wtx' => 'text/plain',
				'wv' => 'video/wavelet',
				'wvx' => 'video/x-ms-wvx',
				'wxl' => 'application/x-wxl',
				'x-gzip' => 'application/x-gzip',
				'x-png' => 'image/png',
				'x3d' => 'application/vnd.hzn-3d-crossword',
				'xaf' => 'x-word/x-vrml',
				'xar' => 'application/vnd.xara',
				'xbd' => 'application/vnd.fujixerox.docuworks.binder',
				'xbm' => array (
						0 => 'image/x-xbitmap',
						1 => 'image/x-xbm',
						2 => 'image/xbm' 
				),
				'xdm' => 'application/x-xdma',
				'xdma' => 'application/x-xdma',
				'xdr' => 'video/x-amt-demorun',
				'xdw' => 'application/vnd.fujixerox.docuworks',
				'xfdl' => 'application/vnd.xfdl',
				'xgz' => 'xgl/drawing',
				'xht' => 'application/xhtml+xml',
				'xhtm' => 'application/xhtml+xml',
				'xhtml' => 'application/xhtml+xml',
				'xif' => 'image/vnd.xiff',
				'xl' => 'application/excel',
				'xla' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel',
						3 => 'application/x-msexcel' 
				),
				'xlb' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel' 
				),
				'xlc' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel' 
				),
				'xld' => array (
						0 => 'application/excel',
						1 => 'application/x-excel' 
				),
				'xlk' => array (
						0 => 'application/excel',
						1 => 'application/x-excel' 
				),
				'xll' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel' 
				),
				'xlm' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel' 
				),
				'xls' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel',
						3 => 'application/x-msexcel' 
				),
				'xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'xlt' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel' 
				),
				'xlv' => array (
						0 => 'application/excel',
						1 => 'application/x-excel' 
				),
				'xlw' => array (
						0 => 'application/excel',
						1 => 'application/vnd.ms-excel',
						2 => 'application/x-excel',
						3 => 'application/x-msexcel' 
				),
				'xm' => array (
						0 => 'audio/x-mod',
						1 => 'audio/xm' 
				),
				'xml' => array (
						0 => 'application/xml',
						1 => 'text/vnd.IPTC.NITF',
						2 => 'text/vnd.IPTC.NewsML',
						3 => 'text/vnd.wap.si',
						4 => 'text/vnd.wap.sl',
						5 => 'text/vnd.wap.wml',
						6 => 'text/xml' 
				),
				'xmz' => array (
						0 => 'audio/x-mod',
						1 => 'xgl/movie' 
				),
				'xof' => 'x-world/x-vrml',
				'xpi' => 'application/x-xpinstall',
				'xpix' => 'application/x-vnd.ls-xpix',
				'xpm' => array (
						0 => 'image/x-xpixmap',
						1 => 'image/x-xpm',
						2 => 'image/xpm' 
				),
				'xpr' => 'application/vnd.is-xpr',
				'xpw' => 'application/vnd.intercon.formnet',
				'xpx' => 'application/vnd.intercon.formnet',
				'xsit' => 'text/xml',
				'xsl' => array (
						0 => 'text/xml',
						1 => 'text/xsl' 
				),
				'xsr' => 'video/x-amt-showrun',
				'xul' => 'text/xul',
				'xwd' => array (
						0 => 'image/x-xwd',
						1 => 'image/x-xwindowdump' 
				),
				'xyz' => array (
						0 => 'chemical/x-pdb',
						1 => 'chemical/x-xyz' 
				),
				'yz1' => 'application/x-yz1',
				'z' => array (
						0 => 'application/x-compress',
						1 => 'application/x-compressed' 
				),
				'zac' => 'application/x-zaurus-zac',
				'zip' => array (
						0 => 'application/x-compressed',
						1 => 'application/x-zip-compressed',
						2 => 'application/zip',
						3 => 'multipart/x-zip' 
				),
				'zoo' => 'application/octet-stream',
				'zsh' => 'text/x-script.zsh',
				'ztardist' => 'application/x-ztardist',
				'.fly' => 'flv-application/octet-stream' 
		);
	}
}