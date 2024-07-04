/**
 *  Form Wizard
 */

// console.log("dddddddddddddd");

function customValidation(id1, id2) {
  if (getCheckedRadioValue(id1) == 'Oui' && !document.getElementById(id2).value) {
    $(`#${id2}`).addClass('border').addClass('border-danger');
    $(`#msg_validation_${id2}`).removeClass('d-none');
  } else {
    $(`#${id2}`).removeClass('border').removeClass('border-danger');
    $(`#msg_validation_${id2}`).addClass('d-none');
  }

  document.getElementById(id2).addEventListener('input', function () {
    if (getCheckedRadioValue(id1) == 'Oui' && !document.getElementById(id2).value) {
      $(`#${id2}`).addClass('border').addClass('border-danger');
      $(`#msg_validation_${id2}`).removeClass('d-none');
    } else {
      $(`#${id2}`).removeClass('border').removeClass('border-danger');
      $(`#msg_validation_${id2}`).addClass('d-none');
    }
  });
}

function getCheckedRadioValue(name) {
  var radios = document.getElementsByName(name);

  for (var i = 0; i < radios.length; i++) {
    if (radios[i].checked) {
      return radios[i].value;
    }
  }
  return null;
}

function serializeArrayToObject(formDataArray) {
  let formDataObject = {};
  formDataArray.forEach(function (item) {
    let itemName = item.name;
    if (item.name.endsWith('[]')) {
      itemName = item.name.slice(0, -2);
      if (!formDataObject[itemName]) {
        formDataObject[itemName] = [];
      }
      formDataObject[itemName].push(item.value);
    } else {
      formDataObject[itemName] = item.value;
    }
  });

  return formDataObject;
}

('use strict');

function sweetAlertErrorMessage() {
  Swal.fire({
    icon: 'error',
    title: 'Oups...',
    html: "Quelque chose s'est mal passé ! <br/> Essayez de rafraîchir la page. <br/> <br/> Si l'erreur persiste, merci de contacter l'équipe de support.",
    customClass: {
      confirmButton: 'btn btn-danger waves-effect waves-light'
    }
  });
}
(function () {
  const select2 = $('.select2'),
    selectPicker = $('.selectpicker');

  // Wizard Validation
  // --------------------------------------------------------------------
  const wizardValidation = document.querySelector('#wizard-validation');
  if (typeof wizardValidation !== undefined && wizardValidation !== null) {
    // Wizard form
    const wizardValidationForm = wizardValidation.querySelector('#wizard-validation-form');
    // Wizard steps
    const wizardValidationFormStep1 = wizardValidationForm.querySelector('#step-1-validation');
    const wizardValidationFormStep2 = wizardValidationForm.querySelector('#step-2-validation');
    const wizardValidationFormStep3 = wizardValidationForm.querySelector('#step-3-validation');
    const wizardValidationFormStep4 = wizardValidationForm.querySelector('#step-4-validation');
    const wizardValidationFormStep5 = wizardValidationForm.querySelector('#step-5-validation');
    const wizardValidationFormStep6 = wizardValidationForm.querySelector('#step-6-validation');
    // Wizard next prev button
    const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
    const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));

    const validationStepper = new Stepper(wizardValidation, {
      linear: true
    });

    // validationStepper.next();
    // validationStepper.next();
    // validationStepper.next();
    // validationStepper.next();
    // validationStepper.next();

    // Account details
    const FormValidation1 = FormValidation.formValidation(wizardValidationFormStep1, {
      fields: {
        entreprise_name: {
          validators: {
            notEmpty: {
              message: `Le nom de l'entreprise est requis`
            },
            stringLength: {
              min: 2,
              max: 40,
              message: `Le nom de l'entreprise doit contenir entre 2 et 40 caractères`
            },
            regexp: {
              regexp: /^[a-zA-Z0-9 ]+$/,
              message: `Le nom de l'entreprise ne peut contenir que des lettres, des chiffres et des espaces`
            }
          }
        },
        contact_person: {
          validators: {
            notEmpty: {
              message: 'Le nom de la personne à contacter est requis'
            },
            stringLength: {
              min: 2,
              max: 40,
              message: 'Le nom doit contenir entre 2 et 40 caractères'
            },
            regexp: {
              regexp: /^[a-zA-Z0-9 ]+$/,
              message: 'Le nom ne peut contenir que des lettres, des chiffres et des espaces'
            }
          }
        },
        phone: {
          validators: {
            notEmpty: {
              message: 'Le numéro de téléphone est requis'
            },
            regexp: {
              regexp: /^[\d()+\- ]+$/,
              message: 'Veuillez fournir un numéro de téléphone valide'
            }
          }
        },
        email: {
          validators: {
            notEmpty: {
              message: "L'adresse email est requise"
            },
            emailAddress: {
              message: 'Veuillez fournir une adresse email valide'
            }
          }
        },
        has_website: {
          validators: {
            notEmpty: {
              message: 'Ce champ est requis.'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.validation-field'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          //* Move the error message out of the `input-group` element
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });
      }
    }).on('core.form.valid', function () {
      // => Step 1
      $('#next-step-1').addClass('disabled');
      $('#icon-next-step-1').removeClass().addClass('ti ti-loader rotate');

      setTimeout(() => {
        let specification_id = $('#specification_id').val();
        let formElement = document.getElementById('step-1-validation-form');
        let formData = new FormData(formElement);

        if (specification_id) {
          $.ajax({
            url: `/specifications/step1/${specification_id}`,
            type: 'GET',
            success: function (response) {
              $.ajax({
                type: 'POST',
                url: `/specifications/step1/${response.result.id}`,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                  console.log(response);
                  $('#next-step-1').removeClass('disabled');
                  $('#icon-next-step-1').removeClass().addClass('ti ti-arrow-right');
                  validationStepper.next();
                },
                error: function (xhr, status, error) {
                  $('#next-step-1').removeClass('disabled');
                  $('#icon-next-step-1').removeClass().addClass('ti ti-arrow-right');
                  sweetAlertErrorMessage();
                }
              });
            },
            error: function (xhr, status, error) {
              $('#next-step-1').removeClass('disabled');
              $('#icon-next-step-1').removeClass().addClass('ti ti-arrow-right');
              sweetAlertErrorMessage();
            }
          });
        } else {
          $.ajax({
            url: '/specifications/step1',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
              console.log('insert success', response);
              $('#next-step-1').removeClass('disabled');
              $('#icon-next-step-1').removeClass().addClass('ti ti-arrow-right');
              $('#specification_id').val(response.record_id);
              validationStepper.next();
            },
            error: function (xhr, status, error) {
              $('#next-step-1').removeClass('disabled');
              $('#icon-next-step-1').removeClass().addClass('ti ti-arrow-right');
              sweetAlertErrorMessage();
            }
          });
        }
      }, 50);
    });

    // Personal info
    const FormValidation2 = FormValidation.formValidation(wizardValidationFormStep2, {
      fields: {
        // project_need: {
        //   validators: {
        //     notEmpty: {
        //       message: 'Le besoin du projet est requis'
        //     }
        //   }
        // },
        project_type: {
          validators: {
            notEmpty: {
              message: 'Le type de projet est requis'
            }
          }
        },
        'languages[]': {
          validators: {
            notEmpty: {
              message: 'Au moins une langue doit être sélectionnée'
            }
          }
        },
        'expected_functions[]': {
          validators: {
            notEmpty: {
              message: 'Au moins une fonction attendue doit être sélectionnée'
            }
          }
        },
        expected_objectives: {
          validators: {
            notEmpty: {
              message: 'Les objectifs attendus du projet sont requis'
            }
          }
        },
        menu: {
          validators: {
            notEmpty: {
              message: 'Le menu est requis'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.validation-field'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // => Step 2
      console.log(111111);
      console.log(111111);
      $('#next-step-2').addClass('disabled');
      $('#icon-next-step-2').removeClass().addClass('ti ti-loader rotate');

      setTimeout(() => {
        console.log(222222);
        let formElement = document.getElementById('step-2-validation-form');
        let formData = new FormData(formElement);

        let specification_id = $('#specification_id').val();
        let objectif_site_id = $('#objectif_site_id').val();
        formData.append('specification_id', specification_id);

        if (objectif_site_id) {
          console.log(33333333);
          $.ajax({
            url: `/specifications/step2/${objectif_site_id}`,
            type: 'GET',
            success: function (response) {
              console.log(4444444);
              console.log('eeeee');
              $.ajax({
                type: 'POST',
                url: `/specifications/step2/${response.result.id}`,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                  console.log('bbbbb');
                  console.log(response);
                  $('#next-step-2').removeClass('disabled');
                  $('#icon-next-step-2').removeClass().addClass('ti ti-arrow-right');
                  validationStepper.next();
                },
                error: function (xhr, status, error) {
                  $('#next-step-2').removeClass('disabled');
                  $('#icon-next-step-2').removeClass().addClass('ti ti-arrow-right');
                  sweetAlertErrorMessage();
                }
              });
            },
            error: function (xhr, status, error) {
              $('#next-step-2').removeClass('disabled');
              $('#icon-next-step-2').removeClass().addClass('ti ti-arrow-right');

              sweetAlertErrorMessage();
            }
          });
        } else {
          console.log(555555);

          $.ajax({
            url: '/specifications/step2',
            type: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
              console.log('insert success', response);
              $('#next-step-2').removeClass('disabled');
              $('#icon-next-step-2').removeClass().addClass('ti ti-arrow-right');
              $('#objectif_site_id').val(response.record_id);
              validationStepper.next();
            },
            error: function (xhr, status, error) {
              console.log(xhr, status, error);
              $('#next-step-2').removeClass('disabled');
              $('#icon-next-step-2').removeClass().addClass('ti ti-arrow-right');
              sweetAlertErrorMessage();
            }
          });
        }
      }, 50);
    });
    if (selectPicker.length) {
      selectPicker.each(function () {
        var $this = $(this);
        $this.selectpicker().on('change', function () {
          FormValidation2.revalidateField('languages[]');
          FormValidation2.revalidateField('expected_functions[]');
        });
      });
    }

    // select2
    if (select2.length) {
      select2.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this
          .select2({
            placeholder: 'Sélectionnez une option',
            dropdownParent: $this.parent()
          })
          .on('change.select2', function () {
            FormValidation1.revalidateField('has_website');
            FormValidation2.revalidateField('project_need');
            FormValidation2.revalidateField('project_type');
            FormValidation3.revalidateField('domain');
            FormValidation3.revalidateField('hosting');
          });
      });
    }

    const FormValidation3 = FormValidation.formValidation(wizardValidationFormStep3, {
      fields: {
        // Supprimer la validation pour le champ "competitors"
        // competitors: {
        //   validators: {
        //     notEmpty: {
        //       message: 'Veuillez entrer le nom de vos concurrents'
        //     }
        //   }
        // },
        domain: {
          validators: {
            notEmpty: {
              message: 'Veuillez entrer votre domaine'
            }
          }
        },
        hosting: {
          validators: {
            notEmpty: {
              message: "Veuillez spécifier votre choix d'hébergement"
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.validation-field'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      let domaineValue = !!(
        getCheckedRadioValue('domain') == 'Non' ||
        (getCheckedRadioValue('domain') == 'Oui' && document.getElementById('nomDomaine').value)
      );
      let hebergementValue = !!(
        getCheckedRadioValue('hosting') == 'Non' ||
        (getCheckedRadioValue('hosting') == 'Oui' && document.getElementById('nomHebergement').value)
      );
      customValidation('domain', 'nomDomaine');
      customValidation('hosting', 'nomHebergement');
      // if (domaineValue && logoValue && hebergementValue) {
      if (domaineValue && hebergementValue) {
        // => Step 3
        $('#next-step-3').addClass('disabled');
        $('#icon-next-step-3').removeClass().addClass('ti ti-loader rotate');

        setTimeout(() => {
          let formElement = document.getElementById('step-3-validation-form');
          let formData = new FormData(formElement);

          let specification_id = $('#specification_id').val();
          let analyse_existants_id = $('#analyse_existants_id').val();
          formData.append('specification_id', specification_id);

          if (analyse_existants_id) {
            $.ajax({
              url: `/specifications/step3/${analyse_existants_id}`,
              type: 'GET',
              success: function (response) {
                console.log('get success', response);
                $('#next-step-3').removeClass('disabled');
                $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');
                // validationStepper.next();
                $.ajax({
                  type: 'POST',
                  url: `/specifications/step3/${response.result.id}`,
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function (response) {
                    console.log(response);
                    $('#next-step-3').removeClass('disabled');
                    $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');
                    validationStepper.next();
                    $.ajax({
                      url: `/specifications/step3/${analyse_existants_id}`,
                      type: 'GET',
                      success: function (response) {
                        console.log('get success', response);
                        $('#telecharger-images-1').val('');
                        $('#sample_sites_files_container').html('');
                        // validationStepper.next();
                        if (response.result.sample_sites_files) {
                          response.result.sample_sites_files.forEach(element => {
                            let extension = element.split('.').pop().toLowerCase();
                            console.log(extension);
                            let image =
                              extension == 'pdf'
                                ? 'assets/img/pdf/pdf.png'
                                : extension == 'doc' || extension == 'docx'
                                  ? 'assets/img/pdf/doc.png'
                                  : element;
                            $('#sample_sites_files_container').append(`
                              <div class="col-auto">
                                  <div class="d-flex flex-column justify-content-center mb-2">
                                      <div class="rounded border"
                                          style="width: 100px; padding-top: 100px; background-size: cover;
                                          background-position: center; background-image: url(/${image})">
                                      </div>
                                      <div>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                          <a title="Voir" href="/${element}" target="_blank" type="button"
                                          class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                          <button
                                          type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="sample_sites_files"
                                          class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              `);
                          });
                        }
                        $('#telecharger-images-2').val('');
                        $('#constraints_files_container').html('');
                        if (response.result.constraints_files) {
                          response.result.constraints_files.forEach(element => {
                            let extension = element.split('.').pop().toLowerCase();
                            console.log(extension);
                            let image =
                              extension == 'pdf'
                                ? 'assets/img/pdf/pdf.png'
                                : extension == 'doc' || extension == 'docx'
                                  ? 'assets/img/pdf/doc.png'
                                  : element;
                            $('#constraints_files_container').append(`
                              <div class="col-auto">
                                  <div class="d-flex flex-column justify-content-center mb-2">
                                      <div class="rounded border"
                                          style="width: 100px; padding-top: 100px; background-size: cover;
                                          background-position: center; background-image: url(/${image})">
                                      </div>
                                      <div>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                          <a title="Voir" href="/${element}" target="_blank" type="button"
                                          class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                          <button
                                          type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="constraints_files"
                                          class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              `);
                          });
                        }
                      },
                      error: function (xhr, status, error) {
                        $('#next-step-3').removeClass('disabled');
                        $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');

                        sweetAlertErrorMessage();
                      }
                    });
                  },
                  error: function (xhr, status, error) {
                    $('#next-step-3').removeClass('disabled');
                    $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');
                    sweetAlertErrorMessage();
                  }
                });
              },
              error: function (xhr, status, error) {
                $('#next-step-3').removeClass('disabled');
                $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');

                sweetAlertErrorMessage();
              }
            });
          } else {
            $.ajax({
              url: '/specifications/step3',
              type: 'POST',
              processData: false,
              contentType: false,
              data: formData,
              success: function (response) {
                console.log('insert success', response);
                $('#next-step-3').removeClass('disabled');
                $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');
                $('#analyse_existants_id').val(response.record_id);
                validationStepper.next();
                $.ajax({
                  url: `/specifications/step3/${response.record_id}`,
                  type: 'GET',
                  success: function (response) {
                    console.log('get success', response);
                    $('#telecharger-images-1').val('');
                    $('#sample_sites_files_container').html('');
                    if (response.result.sample_sites_files) {
                      response.result.sample_sites_files.forEach(element => {
                        let extension = element.split('.').pop().toLowerCase();
                        console.log(extension);
                        let image =
                          extension == 'pdf'
                            ? 'assets/img/pdf/pdf.png'
                            : extension == 'doc' || extension == 'docx'
                              ? 'assets/img/pdf/doc.png'
                              : element;
                        $('#sample_sites_files_container').append(`
                          <div class="col-auto">
                              <div class="d-flex flex-column justify-content-center mb-2">
                                  <div class="rounded border"
                                      style="width: 100px; padding-top: 100px; background-size: cover;
                                      background-position: center; background-image: url(/${image})">
                                  </div>
                                  <div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                      <a title="Voir" href="/${element}" target="_blank" type="button"
                                      class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                      <button
                                      type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="sample_sites_files"
                                      class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          `);
                      });
                    }
                    $('#telecharger-images-2').val('');
                    $('#constraints_files_container').html('');
                    if (response.result.constraints_files) {
                      response.result.constraints_files.forEach(element => {
                        let extension = element.split('.').pop().toLowerCase();
                        console.log(extension);
                        let image =
                          extension == 'pdf'
                            ? 'assets/img/pdf/pdf.png'
                            : extension == 'doc' || extension == 'docx'
                              ? 'assets/img/pdf/doc.png'
                              : element;
                        $('#constraints_files_container').append(`
                          <div class="col-auto">
                              <div class="d-flex flex-column justify-content-center mb-2">
                                  <div class="rounded border"
                                      style="width: 100px; padding-top: 100px; background-size: cover;
                                      background-position: center; background-image: url(/${image})">
                                  </div>
                                  <div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                      <a title="Voir" href="/${element}" target="_blank" type="button"
                                      class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                      <button
                                      type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="constraints_files"
                                      class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          `);
                      });
                    }
                  },
                  error: function (xhr, status, error) {
                    $('#next-step-3').removeClass('disabled');
                    $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');

                    sweetAlertErrorMessage();
                  }
                });
              },
              error: function (xhr, status, error) {
                $('#next-step-3').removeClass('disabled');
                $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');
                sweetAlertErrorMessage();
              }
            });
          }
        }, 50);
      }
    });

    $(document).on('click', '.deletefile', function () {
      Swal.fire({
        title: 'Êtes-vous sûr?',
        text: 'Vous ne pourrez pas annuler cette action!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Annuler'
      }).then(result => {
        if (result.isConfirmed) {
          var id = $(this).data('id');
          var href = $(this).data('href');
          var type = $(this).data('type');
          var csrfToken = $('meta[name="csrf-token"]').attr('content');
          var formData = new FormData();
          formData.append('href', href);
          formData.append('type', type);

          $(this).html('`<i class="ti ti-loader rotate"></i>').prop('disabled', true);

          $.ajax({
            url: '/deletefile/' + id,
            type: 'POST',
            headers: {
              'X-CSRF-Token': csrfToken
            },
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
              console.log(response);
              $.ajax({
                url: `/specifications/step3/${id}`,
                type: 'GET',
                success: function (response) {
                  console.log('get success', response);
                  $('#telecharger-images-1').val('');
                  $('#sample_sites_files_container').html('');
                  if (response.result.sample_sites_files) {
                    response.result.sample_sites_files.forEach(element => {
                      let extension = element.split('.').pop().toLowerCase();
                      console.log(extension);
                      let image =
                        extension == 'pdf'
                          ? 'assets/img/pdf/pdf.png'
                          : extension == 'doc' || extension == 'docx'
                            ? 'assets/img/pdf/doc.png'
                            : element;
                      $('#sample_sites_files_container').append(`
                      <div class="col-auto">
                          <div class="d-flex flex-column justify-content-center mb-2">
                              <div class="rounded border"
                                  style="width: 100px; padding-top: 100px; background-size: cover;
                                  background-position: center; background-image: url(/${image})">
                              </div>
                              <div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                  <a title="Voir" href="/${element}" target="_blank" type="button"
                                  class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                  <button
                                  type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="sample_sites_files"
                                  class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                </div>
                              </div>
                          </div>
                      </div>
                      `);
                    });
                  }
                  $('#telecharger-images-2').val('');
                  $('#constraints_files_container').html('');
                  if (response.result.constraints_files) {
                    response.result.constraints_files.forEach(element => {
                      let extension = element.split('.').pop().toLowerCase();
                      console.log(extension);
                      let image =
                        extension == 'pdf'
                          ? 'assets/img/pdf/pdf.png'
                          : extension == 'doc' || extension == 'docx'
                            ? 'assets/img/pdf/doc.png'
                            : element;
                      $('#constraints_files_container').append(`
                      <div class="col-auto">
                          <div class="d-flex flex-column justify-content-center mb-2">
                              <div class="rounded border"
                                  style="width: 100px; padding-top: 100px; background-size: cover;
                                  background-position: center; background-image: url(/${image})">
                              </div>
                              <div>
                                <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                  <a title="Voir" href="/${element}" target="_blank" type="button"
                                  class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                  <button
                                  type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="constraints_files"
                                  class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                </div>
                              </div>
                          </div>
                      </div>
                      `);
                    });
                  }
                },
                error: function (xhr, status, error) {
                  $('#next-step-3').removeClass('disabled');
                  $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');

                  sweetAlertErrorMessage();
                }
              });
            },
            error: function (xhr, status, error) {
              console.error('Error deleting item:', error);
            }
          });
        }
      });
    });

    const FormValidation4 = FormValidation.formValidation(wizardValidationFormStep4, {
      fields: {
        'styleGraphique[]': {
          validators: {
            notEmpty: {
              message: 'La sélection du style graphique est requise'
            }
          }
        },
        nombrePropositions: {
          validators: {
            notEmpty: {
              message: 'La sélection du nombre de propositions est requise'
            }
          }
        },
        color_palette: {
          validators: {
            notEmpty: {
              message: 'Veuillez entrer une palette de couleurs. Ce champ est requis.'
            }
          }
        },
        logo: {
          validators: {
            notEmpty: {
              message: ' &nbsp; '
            }
          }
        },
        graphical_charter: {
          validators: {
            notEmpty: {
              message: ' &nbsp; '
            }
          }
        },
        wireframe: {
          validators: {
            notEmpty: {
              message: ' &nbsp; '
            }
          }
        },
        typography: {
          validators: {
            notEmpty: {
              message: ' &nbsp; '
            }
          }
        },
        description_product_services: {
          validators: {
            notEmpty: {
              message: ' &nbsp; '
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.validation-field'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // => Step 4
      $('#autreProposition').on('input', function () {
        if ($('#nombrePropositions').val() == 'autre' && !$('#autreProposition').val()) {
          console.log('eee');
          $('#autreProposition').addClass('border').addClass('border-danger');
          $('#msg_autreProposition').removeClass('d-none');
        } else {
          console.log('rrr');
          $('#autreProposition').removeClass('border').removeClass('border-danger');
          $('#msg_autreProposition').addClass('d-none');
        }
      });

      if ($('#nombrePropositions').val() == 'autre' && !$('#autreProposition').val()) {
        $('#autreProposition').addClass('border').addClass('border-danger');
        $('#msg_autreProposition').removeClass('d-none');
      } else {
        $('#autreProposition').removeClass('border').removeClass('border-danger');
        $('#msg_autreProposition').addClass('d-none');

        $('#next-step-4').addClass('disabled');
        $('#icon-next-step-4').removeClass().addClass('ti ti-loader rotate');

        setTimeout(() => {
          let formElement = document.getElementById('step-4-validation-form');
          let formData = new FormData(formElement);

          let specification_id = $('#specification_id').val();
          let content_id = $('#content_id').val();
          formData.append('specification_id', specification_id);

          if (content_id) {
            $.ajax({
              url: `/specifications/step4/${content_id}`,
              type: 'GET',
              success: function (response) {
                console.log('get success', response);
                $('#next-step-4').removeClass('disabled');
                $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');
                // validationStepper.next();
                $.ajax({
                  type: 'POST',
                  url: `/specifications/step4/${response.result.id}`,
                  data: formData,
                  processData: false,
                  contentType: false,
                  success: function (response) {
                    console.log(response);
                    $('#next-step-4').removeClass('disabled');
                    $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');
                    validationStepper.next();
                    $.ajax({
                      url: `/specifications/step4/${content_id}`,
                      type: 'GET',
                      success: function (response) {
                        console.log('get success', response);
                        $('#telecharger-images-1').val('');
                        $('#sample_sites_files_container').html('');
                        if (response.result.sample_sites_files) {
                          response.result.sample_sites_files.forEach(element => {
                            let extension = element.split('.').pop().toLowerCase();
                            console.log(extension);
                            let image =
                              extension == 'pdf'
                                ? 'assets/img/pdf/pdf.png'
                                : extension == 'doc' || extension == 'docx'
                                  ? 'assets/img/pdf/doc.png'
                                  : element;
                            $('#sample_sites_files_container').append(`
                              <div class="col-auto">
                                  <div class="d-flex flex-column justify-content-center mb-2">
                                      <div class="rounded border"
                                          style="width: 100px; padding-top: 100px; background-size: cover;
                                          background-position: center; background-image: url(/${image})">
                                      </div>
                                      <div>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                          <a title="Voir" href="/${element}" target="_blank" type="button"
                                          class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                          <button
                                          type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="sample_sites_files"
                                          class="btn btn-outline-danger deletefile"><i class="ti ti-trash"></i></button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              `);
                          });
                        }
                        $('#telecharger-images-3').val('');
                        $('#exemples_sites_files_container').html('');
                        if (response.result.exemples_sites_files) {
                          response.result.exemples_sites_files.forEach(element => {
                            let extension = element.split('.').pop().toLowerCase();
                            console.log(extension);
                            let image =
                              extension == 'pdf'
                                ? 'assets/img/pdf/pdf.png'
                                : extension == 'doc' || extension == 'docx'
                                  ? 'assets/img/pdf/doc.png'
                                  : element;
                            $('#exemples_sites_files_container').append(`
                              <div class="col-auto">
                                  <div class="d-flex flex-column justify-content-center mb-2">
                                      <div class="rounded border"
                                          style="width: 100px; padding-top: 100px; background-size: cover;
                                          background-position: center; background-image: url(/${image})">
                                      </div>
                                      <div>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                          <a title="Voir" href="/${element}" target="_blank" type="button"
                                          class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                          <button
                                          type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="exemples_sites_files"
                                          class="btn btn-outline-danger deletefile2"><i class="ti ti-trash"></i></button>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                              `);
                          });
                        }
                      },
                      error: function (xhr, status, error) {
                        $('#next-step-4').removeClass('disabled');
                        $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');

                        sweetAlertErrorMessage();
                      }
                    });
                  },
                  error: function (xhr, status, error) {
                    $('#next-step-4').removeClass('disabled');
                    $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');
                    sweetAlertErrorMessage();
                  }
                });
              },
              error: function (xhr, status, error) {
                $('#next-step-4').removeClass('disabled');
                $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');

                sweetAlertErrorMessage();
              }
            });
          } else {
            $.ajax({
              url: '/specifications/step4',
              type: 'POST',
              processData: false,
              contentType: false,
              data: formData,
              success: function (response) {
                console.log('insert success', response);
                $('#next-step-4').removeClass('disabled');
                $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');
                $('#content_id').val(response.record_id);
                validationStepper.next();
                $.ajax({
                  url: `/specifications/step4/${response.record_id}`,
                  type: 'GET',
                  success: function (response) {
                    console.log('get success', response);
                    $('#telecharger-images-3').val('');
                    $('#exemples_sites_files_container').html('');
                    if (response.result.exemples_sites_files) {
                      response.result.exemples_sites_files.forEach(element => {
                        let extension = element.split('.').pop().toLowerCase();
                        console.log(extension);
                        let image =
                          extension == 'pdf'
                            ? 'assets/img/pdf/pdf.png'
                            : extension == 'doc' || extension == 'docx'
                              ? 'assets/img/pdf/doc.png'
                              : element;
                        $('#exemples_sites_files_container').append(`
                          <div class="col-auto">
                              <div class="d-flex flex-column justify-content-center mb-2">
                                  <div class="rounded border"
                                      style="width: 100px; padding-top: 100px; background-size: cover;
                                      background-position: center; background-image: url(/${image})">
                                  </div>
                                  <div>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                      <a title="Voir" href="/${element}" target="_blank" type="button"
                                      class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                      <button
                                      type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="exemples_sites_files"
                                      class="btn btn-outline-danger deletefile2"><i class="ti ti-trash"></i></button>
                                    </div>
                                  </div>
                              </div>
                          </div>
                          `);
                      });
                    }
                  },
                  error: function (xhr, status, error) {
                    $('#next-step-3').removeClass('disabled');
                    $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');

                    sweetAlertErrorMessage();
                  }
                });
              },
              error: function (xhr, status, error) {
                $('#next-step-4').removeClass('disabled');
                $('#icon-next-step-4').removeClass().addClass('ti ti-arrow-right');
                sweetAlertErrorMessage();
              }
            });
          }
        }, 50);
      }
    });

    $(document).on('click', '.deletefile2', function () {
      Swal.fire({
        title: 'Êtes-vous sûr?',
        text: 'Vous ne pourrez pas annuler cette action!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer!',
        cancelButtonText: 'Annuler'
      }).then(result => {
        if (result.isConfirmed) {
          var id = $(this).data('id');
          var href = $(this).data('href');
          var type = $(this).data('type');
          var csrfToken = $('meta[name="csrf-token"]').attr('content');
          var formData = new FormData();
          formData.append('href', href);
          formData.append('type', type);
          $(this).html('`<i class="ti ti-loader rotate"></i>').prop('disabled', true);

          $.ajax({
            url: '/deletefile/' + id,
            type: 'POST',
            headers: {
              'X-CSRF-Token': csrfToken
            },
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {
              console.log(response);
              $.ajax({
                url: `/specifications/step4/${id}`,
                type: 'GET',
                success: function (response) {
                  console.log('get success', response);
                  $('#telecharger-images-1').val('');
                  $('#exemples_sites_files_container').html('');
                  if (response.result.exemples_sites_files) {
                    response.result.exemples_sites_files.forEach(element => {
                      let extension = element.split('.').pop().toLowerCase();
                      console.log(extension);
                      let image =
                        extension == 'pdf'
                          ? 'assets/img/pdf/pdf.png'
                          : extension == 'doc' || extension == 'docx'
                            ? 'assets/img/pdf/doc.png'
                            : element;
                      $('#exemples_sites_files_container').append(`
                        <div class="col-auto">
                            <div class="d-flex flex-column justify-content-center mb-2">
                                <div class="rounded border"
                                    style="width: 100px; padding-top: 100px; background-size: cover;
                                    background-position: center; background-image: url(/${image})">
                                </div>
                                <div>
                                  <div class="btn-group btn-group-sm" role="group" aria-label="First group">
                                    <a title="Voir" href="/${element}" target="_blank" type="button"
                                    class="btn btn-outline-info"><i class="ti ti-eye"></i></a>
                                    <button
                                    type="button" title="Supprimer" data-id="${response.result.id}" data-href="${element}" data-type="exemples_sites_files"
                                    class="btn btn-outline-danger deletefile2"><i class="ti ti-trash"></i></button>
                                  </div>
                                </div>
                            </div>
                        </div>
                        `);
                    });
                  }
                },
                error: function (xhr, status, error) {
                  $('#next-step-3').removeClass('disabled');
                  $('#icon-next-step-3').removeClass().addClass('ti ti-arrow-right');

                  sweetAlertErrorMessage();
                }
              });
            },
            error: function (xhr, status, error) {
              console.error('Error deleting item:', error);
            }
          });
        }
      });
    });

    const FormValidation5 = FormValidation.formValidation(wizardValidationFormStep5, {
      fields: {
        gestion_projet: {
          validators: {
            notEmpty: {
              message: 'La sélection de la gestion du projet est requise'
            }
          }
        },
        'communication[]': {
          validators: {
            notEmpty: {
              message: 'La sélection des modes de communication est requise'
            }
          }
        },
        deadline: {
          validators: {
            notEmpty: {
              message: 'Le délais est requis'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.validation-field'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      // => Step 5
      let formElement = document.getElementById('step-5-validation-form');
      let formData = new FormData(formElement);
      let specification_id = $('#specification_id').val();
      let objectif_site_id = $('#objectif_site_id').val();
      let analyse_existants_id = $('#analyse_existants_id').val();
      let content_id = $('#content_id').val();
      let deadline_id = $('#deadline_id').val();
      formData.append('specification_id', specification_id);
      formData.append('objectif_site_id', objectif_site_id);
      formData.append('analyse_existants_id', analyse_existants_id);
      formData.append('content_id', content_id);

      $('#next-step-5').addClass('disabled');
      $('#icon-next-step-5').removeClass().addClass('ti ti-loader rotate');
      if (deadline_id) {
        $.ajax({
          url: `/specifications/step5/${deadline_id}`,
          type: 'GET',
          success: function (response) {
            console.log('get success', response);
            $('#next-step-5').removeClass('disabled');
            $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
            $.ajax({
              type: 'POST',
              url: `/specifications/step5/${deadline_id}`,
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                $('#next-step-5').removeClass('disabled');
                $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
                $('#deadline_id').val(response.record_id);
                validationStepper.next();
                function allValuesFilled(obj) {
                  for (let key in obj) {
                    console.log(obj[key]);
                    if (obj.hasOwnProperty(key) && obj[key] && (obj[key] === 'loading' || obj[key] === '')) {
                      return false;
                    }
                  }
                  return true;
                }
                function hasErrorValus(obj) {
                  for (let key in obj) {
                    console.log(obj[key]);
                    if (obj.hasOwnProperty(key) && obj[key] === 'error') {
                      return true;
                    }
                  }
                  return false;
                }
                function executeAjax(ai_texts_object) {
                  console.log(ai_texts_object);

                  let formData = objectToFormData(ai_texts_object);
                  $.ajax({
                    headers: {},
                    url: '/specifications/step6',
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                      console.log('insert success', response);
                      let ai_texts_object = {
                        iatext_description: $('#descriptionEntreprise').val(),
                        iatext_main_activities: $('#activitePrincipale').val(),
                        iatext_services_products: $('#servicesProduits').val(),
                        iatext_target_audience: $('#target_audience').val(),
                        iatext_target_keywords: $('#iatext_target_keywords').val(),
                        iatext_expected_client_objectives: $('#expectedObjectives').val(),
                        iatext_menu: $('#iatext_menu').val(),
                        iatext_techniques_specs: $('#iatext_techniques_specs').val(),
                        iatext_competitors: $('#iatext_competitors').val(),
                        iatext_constraints: $('#iatext_constraints').val(),
                        iatext_exemples_sites: $('#iatext_exemples_sites').val()
                      };
                      if (hasErrorValus(ai_texts_object)) {
                        $('#spec-loading').addClass('d-none');
                        $('#spec-failed').removeClass('d-none');
                      } else {
                        $('#spec-loading').addClass('d-none');
                        $('#spec-done').removeClass('d-none');
                        $('#spec-button').removeClass('d-none');

                        let specification_id = $('#specification_id').val();
                        if (specification_id) {
                          $('#spec-button-show').prop('href', `/specifications/${specification_id}`);
                          $('#spec-button-download').prop('href', `/specifications/upload/${specification_id}`);
                        }
                      }
                      console.log('heeeeeeeeeeere 2');
                      console.log(hasErrorValus(ai_texts_object));
                      console.log('heeeeeeeeeeere 3');

                      $.ajax({
                        url: '/notifications',
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                          getNotificationsCount(response);
                          getNotifications(response);
                        },
                        error: function (xhr, status, error) {
                          console.error('Error fetching notifications:', error);
                        }
                      });
                    },
                    error: function (xhr, status, error) {
                      console.log(xhr, status, error);
                    }
                  });
                }
                let intervalId = setInterval(function () {
                  let ai_texts_object = {
                    _token: window.csrfToken,
                    specification_id: $('#specification_id').val(),
                    iatext_description: $('#descriptionEntreprise').val(),
                    iatext_main_activities: $('#activitePrincipale').val(),
                    iatext_services_products: $('#servicesProduits').val(),
                    iatext_target_audience: $('#target_audience').val(),
                    iatext_target_keywords: $('#iatext_target_keywords').val(),
                    iatext_expected_client_objectives: $('#expectedObjectives').val(),
                    iatext_menu: $('#iatext_menu').val(),
                    iatext_techniques_specs: $('#iatext_techniques_specs').val(),
                    iatext_competitors: $('#iatext_competitors').val(),
                    iatext_constraints: $('#iatext_constraints').val(),
                    iatext_exemples_sites: $('#iatext_exemples_sites').val()
                  };
                  if (allValuesFilled(ai_texts_object)) {
                    clearInterval(intervalId);
                    executeAjax(ai_texts_object);
                  }
                }, 500);
              },
              error: function (xhr, status, error) {
                $('#next-step-5').removeClass('disabled');
                $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
                sweetAlertErrorMessage();
              }
            });
          },
          error: function (xhr, status, error) {
            $('#next-step-5').removeClass('disabled');
            $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
            sweetAlertErrorMessage();
          }
        });
      } else {
        $.ajax({
          url: '/specifications/step5',
          type: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: function (response) {
            console.log('insert success', response);
            $('#next-step-5').removeClass('disabled');
            $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
            $('#deadline_id').val(response.record_id);
            validationStepper.next();
            console.log('heeeeeeeeeere 1');
            function allValuesFilled(obj) {
              for (let key in obj) {
                console.log(obj[key]);
                console.log(!obj[key]);
                if (obj.hasOwnProperty(key) && obj[key] && (obj[key] === 'loading' || obj[key] === '')) {
                  return false;
                }
              }
              return true;
            }
            function hasErrorValus(obj) {
              for (let key in obj) {
                console.log(obj[key]);
                if (obj.hasOwnProperty(key) && obj[key] === 'error') {
                  return true;
                }
              }
              return false;
            }
            function executeAjax(ai_texts_object) {
              console.log(ai_texts_object);

              let formData = objectToFormData(ai_texts_object);
              $.ajax({
                headers: {},
                url: '/specifications/step6',
                type: 'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                  console.log('insert success', response);
                  let ai_texts_object = {
                    _token: window.csrfToken,
                    specification_id: $('#specification_id').val(),
                    iatext_description: $('#descriptionEntreprise').val(),
                    iatext_main_activities: $('#activitePrincipale').val(),
                    iatext_services_products: $('#servicesProduits').val(),
                    iatext_target_audience: $('#target_audience').val(),
                    iatext_target_keywords: $('#iatext_target_keywords').val(),
                    iatext_expected_client_objectives: $('#expectedObjectives').val(),
                    iatext_menu: $('#iatext_menu').val(),
                    iatext_techniques_specs: $('#iatext_techniques_specs').val(),
                    iatext_competitors: $('#iatext_competitors').val(),
                    iatext_constraints: $('#iatext_constraints').val(),
                    iatext_exemples_sites: $('#iatext_exemples_sites').val(),
                    send_email: 0
                  };
                  console.log('-------------');
                  if (hasErrorValus(ai_texts_object)) {
                    $('#spec-loading').addClass('d-none');
                    $('#spec-failed').removeClass('d-none');
                  } else {
                    $('#spec-loading').addClass('d-none');
                    $('#spec-confirm').removeClass('d-none');
                    //
                    $('#iatext_description_confirm').val($('#descriptionEntreprise').val());
                    $('#iatext_main_activities_confirm').val($('#activitePrincipale').val());
                    $('#iatext_services_products_confirm').val($('#servicesProduits').val());
                    $('#iatext_target_audience_confirm').val($('#target_audience').val());
                    $('#iatext_target_keywords_confirm').val($('#iatext_target_keywords').val());
                    $('#iatext_expected_client_objectives_confirm').val($('#expectedObjectives').val());
                    $('#iatext_menu_confirm').val($('#iatext_menu').val());
                    $('#iatext_techniques_specs_confirm').val($('#iatext_techniques_specs').val());
                    $('#iatext_competitors_confirm').val($('#iatext_competitors').val());
                    $('#iatext_constraints_confirm').val($('#iatext_constraints').val());
                    $('#iatext_exemples_sites_confirm').val($('#iatext_exemples_sites').val());
                    //
                    $('#spec-confirm-button').on('click', function () {
                      // $('#next-step-5').removeClass('disabled');
                      // $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
                      // $('#spec-confirm').addClass('d-none');
                      $('#spec-confirm-button').addClass('disabled');
                      $('#icon-spec-confirm').removeClass().addClass('ti ti-loader rotate');

                      let ai_texts_object_confirm = {
                        _token: window.csrfToken,
                        specification_id: $('#specification_id').val(),
                        iatext_description: $('#iatext_description_confirm').val(),
                        iatext_main_activities: $('#iatext_main_activities_confirm').val(),
                        iatext_services_products: $('#iatext_services_products_confirm').val(),
                        iatext_target_audience: $('#iatext_target_audience_confirm').val(),
                        iatext_target_keywords: $('#iatext_target_keywords_confirm').val(),
                        iatext_expected_client_objectives: $('#iatext_expected_client_objectives_confirm').val(),
                        iatext_menu: $('#iatext_menu_confirm').val(),
                        iatext_techniques_specs: $('#iatext_techniques_specs_confirm').val(),
                        iatext_competitors: $('#iatext_competitors_confirm').val(),
                        iatext_constraints: $('#iatext_constraints_confirm').val(),
                        iatext_exemples_sites: $('#iatext_exemples_sites_confirm').val(),
                        send_email: 1
                      };
                      let formData_confirm = objectToFormData(ai_texts_object_confirm);
                      $.ajax({
                        headers: {},
                        url: '/specifications/step6',
                        type: 'POST',
                        processData: false,
                        contentType: false,
                        data: formData_confirm,
                        success: function (response) {
                          $('#spec-done').removeClass('d-none');
                          $('#spec-button').removeClass('d-none');
                          $('#spec-confirm').addClass('d-none');

                          let specification_id = $('#specification_id').val();
                          if (specification_id) {
                            $('#spec-button-show').prop('href', `/specifications/${specification_id}`);
                            $('#spec-button-download').prop('href', `/specifications/upload/${specification_id}`);
                          }

                          $.ajax({
                            url: '/notifications',
                            type: 'GET',
                            dataType: 'json',
                            success: function (response) {
                              getNotificationsCount(response);
                              getNotifications(response);
                            },
                            error: function (xhr, status, error) {
                              console.error('Error fetching notifications:', error);
                            }
                          });
                        },
                        error: function (xhr, status, error) {
                          console.log(xhr, status, error);
                        }
                      });
                    });
                    //
                  }
                  console.log(hasErrorValus(ai_texts_object));
                },
                error: function (xhr, status, error) {
                  console.log(xhr, status, error);
                }
              });
            }

            let intervalId = setInterval(function () {
              let ai_texts_object = {
                _token: window.csrfToken,
                specification_id: $('#specification_id').val(),
                iatext_description: $('#descriptionEntreprise').val(),
                iatext_main_activities: $('#activitePrincipale').val(),
                iatext_services_products: $('#servicesProduits').val(),
                iatext_target_audience: $('#target_audience').val(),
                iatext_target_keywords: $('#iatext_target_keywords').val(),
                iatext_expected_client_objectives: $('#expectedObjectives').val(),
                iatext_menu: $('#iatext_menu').val(),
                iatext_techniques_specs: $('#iatext_techniques_specs').val(),
                iatext_competitors: $('#iatext_competitors').val(),
                iatext_constraints: $('#iatext_constraints').val(),
                iatext_exemples_sites: $('#iatext_exemples_sites').val()
              };
              if (allValuesFilled(ai_texts_object)) {
                clearInterval(intervalId);
                executeAjax(ai_texts_object);
              }
            }, 500);
          },
          error: function (xhr, status, error) {
            $('#next-step-5').removeClass('disabled');
            $('#icon-next-step-5').removeClass().addClass('ti ti-arrow-right');
            sweetAlertErrorMessage();
          }
        });
      }
    });

    const FormValidation6 = FormValidation.formValidation(wizardValidationFormStep6, {
      fields: {},
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          // Use this for enabling/changing valid/invalid class
          // eleInvalidClass: '',
          eleValidClass: '',
          rowSelector: '.validation-field'
        }),
        autoFocus: new FormValidation.plugins.AutoFocus(),
        submitButton: new FormValidation.plugins.SubmitButton()
      }
    }).on('core.form.valid', function () {
      console.log('step6');
      // => Step 6
    });

    wizardValidationNext.forEach(item => {
      item.addEventListener('click', event => {
        // When click the Next button, we will validate the current step
        switch (validationStepper._currentIndex) {
          case 0:
            FormValidation1.validate();
            break;

          case 1:
            FormValidation2.validate();
            break;

          case 2:
            FormValidation3.validate();
            break;

          case 3:
            FormValidation4.validate();
            break;

          case 4:
            FormValidation5.validate();
            break;

          case 5:
            FormValidation6.validate();
            break;

          default:
            break;
        }
      });
    });

    wizardValidationPrev.forEach(item => {
      item.addEventListener('click', event => {
        switch (validationStepper._currentIndex) {
          case 5:
            validationStepper.previous();
            break;

          case 4:
            validationStepper.previous();
            break;

          case 3:
            validationStepper.previous();
            break;

          case 2:
            validationStepper.previous();
            break;

          case 1:
            validationStepper.previous();
            break;

          case 0:

          default:
            break;
        }
      });
    });
  }
})();

function objectToFormData(obj) {
  let formData = new FormData();

  for (let key in obj) {
    if (obj.hasOwnProperty(key)) {
      formData.append(key, obj[key]);
    }
  }

  return formData;
}

function getNotifications(data) {
  if (data.length > 0) {
    $('#notif-list').html('');
    data.forEach(element => {
      const createdAt = new Date(element.created_at);
      const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric'
      };
      const formattedDate = createdAt.toLocaleDateString('fr-FR', options);
      $('#notif-list').append(`
                    <li class="list-group-item list-group-item-action dropdown-notifications-item">
                      <a href='{{ url('/specifications') }}'>
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Nouveau cahier des charges</h6>
                                <p class="mb-0 py-1 small text-dark">Votre cahier des charges est bien élaboré. Cliquez ici pour y accéder.</p>
                                <!-- <a class="btn-link d-none" href="#">Voir</a> <a class="btn-link d-none" href="#">Télécharger</a> <br/> -->
                                <small class="text-muted">${formattedDate}</small>
                            </div>
                            <div class="flex-shrink-0 dropdown-notifications-actions">
                                ${!element.read ? `<a href="javascript:void(0)" class="dropdown-notifications-read"> <span class="badge badge-dot"></span> </a>` : ''}
                            </div>
                        </div>
                      </a>
                    </li>
              `);
    });
  }
}
