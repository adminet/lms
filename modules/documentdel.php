<?php

/*
 * LMS version 1.7-cvs
 *
 *  (C) Copyright 2001-2005 LMS Developers
 *
 *  Please, see the doc/AUTHORS for more information about authors!
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License Version 2 as
 *  published by the Free Software Foundation.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,
 *  USA.
 *
 *  $Id$
 */

if($_GET['is_sure']=="1")
{
	$md5sum = $DB->GetOne('SELECT md5sum FROM documentcontents WHERE docid = ?', array($_GET['id']));

	if($DB->GetOne('SELECT COUNT(*) FROM documentcontents WHERE md5sum = ?',array((string)$md5sum))==1)
	{
		@unlink($_DOC_DIR.'/'.substr($md5sum,0,2).'/'.$md5sum);
	}
	
	$DB->BeginTrans();
	
	$DB->Execute('DELETE FROM documentcontents WHERE docid = ?',array($_GET['id']));
	$DB->Execute('DELETE FROM documents WHERE id = ?',array($_GET['id']));
	
	$DB->CommitTrans();
	
	{
		$SESSION->redirect('?'.$SESSION->get('backto'));
	}
}
	
?>