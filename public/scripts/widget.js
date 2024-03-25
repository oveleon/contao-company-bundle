/*!
 * This file is part of Oveleon Company Bundle.
 *
 * @package     contao-company-bundle
 * @license     MIT
 * @author      Fabian Ekert        <https://github.com/eki89>
 * @author      Sebastian Zoglowek  <https://github.com/zoglo>
 * @copyright   Oveleon             <https://www.oveleon.de/>
 */

/**
 * Provide methods to handle widget creation through ajax requests.
 *
 * @author Sebastian Zoglowek <https://github.com/zoglo>
 */
var CyBackend = {
    /**
     * @param {string} id The ID of the target element
     */
    ColumnWizard: function(id) {
        var table = $(id),
            tbody = table.getElement('tbody'),
            replaceIndex = (i, attribute) => {
                return attribute.replace(/\[[0-9]+]/g, '[' + i + ']');
            },
            makeSortable = function(tbody) {
                var rows = tbody.getChildren(),
                    childs, i, j, select, input;

                for (i=0; i<rows.length; i++) {
                    childs = rows[i].getChildren();
                    for (j=0; j<childs.length; j++) {
                        if (select = childs[j].getElement('select')) {
                            select.name = replaceIndex(i, select.name)
                            select.id = replaceIndex(i, select.id)
                        }
                        if (input = childs[j].getElement('input')) {
                            input.name = replaceIndex(i, input.name);
                            input.id = replaceIndex(i, input.id);
                        }
                    }
                }

                new Sortables(tbody,{
                    constrain: true,
                    opacity: 0.6,
                    handle: '.drag-handle',
                    onComplete: function() {
                        makeSortable(tbody);
                    }
                });
            },
            addEventsTo = function(tr) {
                var command, select, next, ntr, childs, i;
                tr.getElements('button').each(function(bt) {
                    if (bt.hasEvent('click')) return;
                    command = bt.getProperty('data-command');

                    switch (command) {
                        case 'copy':
                            bt.addEvent('click', function() {
                                Backend.getScrollOffset();
                                ntr = new Element('tr');
                                childs = tr.getChildren();
                                for (i=0; i<childs.length; i++) {
                                    next = childs[i].clone(true).inject(ntr, 'bottom');
                                    if (select = childs[i].getElement('select')) {
                                        next.getElement('select').value = select.value;
                                    }
                                }
                                ntr.inject(tr, 'after');
                                if (ntr.getElement('.chzn-container')) {
                                    ntr.getElement('.chzn-container').destroy();
                                }

                                if (ntr.getElement('select.tl_select')) {
                                    new Chosen(ntr.getElement('select.tl_select'));
                                }

                                addEventsTo(ntr);
                                makeSortable(tbody);
                            });
                            break;
                        case 'delete':
                            bt.addEvent('click', function() {
                                Backend.getScrollOffset();
                                if (tbody.getChildren().length > 1) {
                                    tr.destroy();
                                }
                                makeSortable(tbody);
                            });
                            break;
                        case null:
                            bt.addEvent('keydown', function(e) {
                                if (e.event.keyCode == 38) {
                                    e.preventDefault();
                                    if (ntr = tr.getPrevious('tr')) {
                                        tr.inject(ntr, 'before');
                                    } else {
                                        tr.inject(tbody, 'bottom');
                                    }
                                    bt.focus();
                                    makeSortable(tbody);
                                } else if (e.event.keyCode == 40) {
                                    e.preventDefault();
                                    if (ntr = tr.getNext('tr')) {
                                        tr.inject(ntr, 'after');
                                    } else {
                                        tr.inject(tbody, 'top');
                                    }
                                    bt.focus();
                                    makeSortable(tbody);
                                }
                            });
                            break;
                    }
                });
            };

        makeSortable(tbody);

        tbody.getChildren().each(function(tr) {
            addEventsTo(tr);
        });
    }
}